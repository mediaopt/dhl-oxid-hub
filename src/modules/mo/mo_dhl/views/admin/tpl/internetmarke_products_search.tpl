<ul>
    [{foreach from=$suggestions item=suggestion }]
    <li data-suggestion="[{$suggestion->getId()}]">[{$suggestion->getId()}]: [{$suggestion->getFieldData('name')}]</li>
    [{/foreach}]
</ul>
