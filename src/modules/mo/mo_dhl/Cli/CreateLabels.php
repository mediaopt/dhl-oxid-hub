<?php
/**
 * For the full copyright and license information, refer to the accompanying LICENSE file.
 *
 * @copyright 2019 Mediaopt GmbH
 */

namespace Mediaopt\DHL\Cli;


use Mediaopt\DHL\Adapter\DHLAdapter;
use Mediaopt\DHL\Adapter\ParcelShippingRequestBuilder;
use Mediaopt\DHL\Api\ParcelShipping\Client;
use Mediaopt\DHL\Application\Model\Order;
use Mediaopt\DHL\Controller\Admin\ErrorDisplayTrait;
use Mediaopt\DHL\Model\MoDHLLabel;
use OxidEsales\Eshop\Core\DatabaseProvider;
use OxidEsales\Eshop\Core\Registry;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * @author Mediaopt GmbH
 */
class CreateLabels extends Command
{

    use ErrorDisplayTrait;

    /**
     * @var OutputInterface
     */
    protected $output;

    /**
     * @var string[]
     */
    protected $orderStatus = null;

    /**
     */
    protected function configure()
    {
        $this
            ->setName('mo:dhl:create-labels')
            ->addOption('paid', null, InputOption::VALUE_NONE, 'Only create labels for paid orders')
            ->addOption('status', null, InputOption::VALUE_IS_ARRAY | InputOption::VALUE_OPTIONAL, 'A list of order status to check', [])
            ->setDescription('Create labels for DHL shipments.');
    }

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     * @throws \OxidEsales\Eshop\Core\Exception\DatabaseConnectionException
     * @throws \OxidEsales\Eshop\Core\Exception\DatabaseErrorException
     * @throws \OxidEsales\Eshop\Core\Exception\SystemComponentException
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        try {
            $this->output = $output;
            foreach ($input->getOption('status') as $status) {
                if (!in_array($status, $this->getOrderStatus())) {
                    $this->output->writeln($this->translate('%s is not an allowed order status status. Please use one of %s', [$status, implode(', ', $this->getOrderStatus())]));
                    return self::FAILURE;
                }
            }
            if (!$orderIds = $this->getOrderIds($input->getOption('paid'), $input->getOption('status'))) {
                return self::SUCCESS;
            }
            $request = Registry::get(ParcelShippingRequestBuilder::class)->build($orderIds);

            $this->createWithParcelShipping($orderIds, $request);
        } catch (\Exception $e) {
            $this->output->writeln($e->getMessage());
            return self::FAILURE;
        }
        return self::SUCCESS;
    }

    protected function createWithParcelShipping(array $orderIds, array $request)
    {
        [$query, $request] = $request;
        $response = Registry::get(DHLAdapter::class)->buildParcelShipping()->createOrders($request, $query, [], Client::FETCH_RESPONSE);
        $payload = \json_decode($response->getBody(), true);
        $createdLabels = 0;
        foreach ($payload['items'] as $index => $item) {
            $statusInformation = $item['sstatus'];
            $order = \oxNew(Order::class);
            $order->load($orderIds[$index]);
            $order->storeCreationStatus($statusInformation['title']);
            if ($item['sstatus']['statusCode'] < 200 || $item['sstatus']['statusCode'] >= 300) {
                $errors = $this->extractErrorsFromResponsePayload($payload, $index);
                $this->output->writeln($this->translate('MO_DHL__BATCH_ERROR_CREATION_ERROR', [$order->getFieldData('oxordernr'), implode("\n", $errors)]));
                continue;
            }
            $label = MoDHLLabel::fromOrderAndParcelShippingResponseItem($order, $item);
            $label->save();
            $createdLabels++;
        }
        $this->output->writeln($this->translate('MO_DHL__BATCH_LABELS_CREATED', [$createdLabels]));
    }

    /**
     * @param bool     $paid
     * @param string[] $status
     * @return string[]
     * @throws \OxidEsales\Eshop\Core\Exception\DatabaseConnectionException
     * @throws \OxidEsales\Eshop\Core\Exception\DatabaseErrorException
     */
    protected function getOrderIds(bool $paid, array $status)
    {
        $db = DatabaseProvider::getDb(DatabaseProvider::FETCH_MODE_ASSOC);
        $select =
            ' SELECT oxorder.OXID FROM oxorder '
            . ' LEFT JOIN mo_dhl_labels mdl ON oxorder.OXID = mdl.orderId '
            . " WHERE mdl.OXID IS NULL AND MO_DHL_PROCESS != '' "
            . ($paid ? ' AND oxpaid != "0000-00-00 00:00:00"' : '')
            . ($status ? ' AND oxfolder in (' . implode(', ', $db->quoteArray($status)) . ')' : '');
        $orderIds = $db->getCol($select);
        $translationText = 'MO_DHL__BATCH_' . ($paid ? 'PAID_' : '') . 'ORDERS_' . ($status ? 'WITH_STATUS_' : '') . 'FOUND';
        $this->output->writeln($this->translate($translationText, [count($orderIds), implode(', ', $status)]));
        return $orderIds;
    }

    /**
     * @param string $text
     * @param array  $params
     * @return string
     */
    protected function translate(string $text, array $params = []): string
    {
        $message = Registry::getLang()->translateString($text);
        $message = sprintf($message, ...$params);
        return $message;
    }

    /**
     * @return array
     */
    public function getOrderStatus()
    {
        if ($this->orderStatus === null) {
            $this->orderStatus = array_keys(Registry::getConfig()->getConfigParam('aOrderfolder'));
        }
        return $this->orderStatus;
    }
}
