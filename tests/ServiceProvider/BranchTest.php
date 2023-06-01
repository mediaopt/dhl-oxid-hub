<?php

namespace sdk\ServiceProvider;

use Mediaopt\DHL\ServiceProvider\Branch;
use PhpUnit\Framework\TestCase;

/**
 * @author  Mediaopt GmbH
 */
class BranchTest extends TestCase
{
    public function testThatABranchIsABranch()
    {
        $this->assertTrue(Branch::isPackstation('Packstation'));
        $this->assertTrue(Branch::isFiliale('Postfiliale'));
        $this->assertTrue(Branch::isFiliale('Paketshop'));
    }

    public function testThatABranchIsRecognizedDespiteMixedCase()
    {
        $this->assertTrue(Branch::isBranch('PaCkStAtIoN'));
        $this->assertTrue(Branch::isBranch('PoStFiLiAlE'));
        $this->assertTrue(Branch::isBranch('PaKeTsHoP'));
    }

    public function testThatSomethingDifferentToBranchIsNotABranch()
    {
        $this->assertFalse(Branch::isBranch('Filiale'));
        $this->assertFalse(Branch::isBranch('Elbestraße'));
    }

    public function testIsPackstationForAPackstation()
    {
        $this->assertTrue(Branch::isPackstation('Packstation'));
    }

    public function testThatAPackstationIsRecognizedDespiteMixedCase()
    {
        $this->assertTrue(Branch::isPackstation('PaCkStAtIoN'));
    }

    public function testThatSomethingDifferentToPackstationIsNotAPackstation()
    {
        $this->assertFalse(Branch::isPackstation('Paketshop'));
        $this->assertFalse(Branch::isPackstation('Postfiliale'));
        $this->assertFalse(Branch::isPackstation('Filiale'));
        $this->assertFalse(Branch::isPackstation('Elbestraße'));
    }

    public function testIsPostfilialeForAPostfiliale()
    {
        $this->assertTrue(Branch::isPostfiliale('Postfiliale'));
    }

    public function testThatAPostfilialeIsRecognizedDespiteMixedCase()
    {
        $this->assertTrue(Branch::isPostfiliale('PoStFiLiAlE'));
    }

    public function testThatSomethingDifferentToPostfilialeIsNotAPostfiliale()
    {
        $this->assertFalse(Branch::isPostfiliale('Packstation'));
        $this->assertFalse(Branch::isPostfiliale('Paketshop'));
        $this->assertFalse(Branch::isPostfiliale('Filiale'));
        $this->assertFalse(Branch::isPostfiliale('Elbestraße'));
    }

    public function testIsPaketshopForAPaketshop()
    {
        $this->assertTrue(Branch::isPaketshop('Paketshop'));
    }

    public function testThatAPaketshopIsRecognizedDespiteMixedCase()
    {
        $this->assertTrue(Branch::isPaketshop('PaKeTsHoP'));
    }

    public function testThatSomethingDifferentToPaketshopIsNotAPaketshop()
    {
        $this->assertFalse(Branch::isPaketshop('Packstation'));
        $this->assertFalse(Branch::isPaketshop('Postfiliale'));
        $this->assertFalse(Branch::isPaketshop('Filiale'));
        $this->assertFalse(Branch::isPaketshop('Elbestraße'));
    }

    public function testIsFilialeForAFiliale()
    {
        $this->assertTrue(Branch::isFiliale('Postfiliale'));
        $this->assertTrue(Branch::isFiliale('Paketshop'));
    }

    public function testThatAFilialeIsRecognizedDespiteMixedCase()
    {
        $this->assertTrue(Branch::isFiliale('PoStFiLiAlE'));
        $this->assertTrue(Branch::isFiliale('PaKeTsHoP'));
    }

    public function testThatSomethingDifferentToFilialeIsNotAFiliale()
    {
        $this->assertFalse(Branch::isFiliale('Packstation'));
        $this->assertFalse(Branch::isFiliale('Filiale'));
        $this->assertFalse(Branch::isFiliale('Elbestraße'));
    }
}
