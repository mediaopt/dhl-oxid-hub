[{include file="headitem.tpl" title="GENERAL_ADMIN_TITLE"|oxmultilangassign}]

<form name="transfer" id="transfer" action="[{$oViewConf->getSelfLink()}]" method="post">
    [{$oViewConf->getHiddenSid()}]
    <input type="hidden" name="oxid" value="[{$oxid}]">
    <input type="hidden" name="cl" value="order_main">
</form>

<form name="myedit" id="myedit" action="[{$oViewConf->getSelfLink()}]" method="post">
    [{$oViewConf->getHiddenSid()}]
    <input type="hidden" name="cl" value="MoEmpfaengerservicesOrderWunschpaket">
    <input type="hidden" name="fnc" value="save">
    <input type="hidden" name="oxid" value="[{$oxid}]">
    <input type="hidden" name="editval[oxorder__oxid]" value="[{$oxid}]">

    <ul>
        <li>
            <label for="ekp">[{oxmultilang ident="MO_EMPFAENGERSERVICES__EKP"}]:</label>
            <input id="ekp" name="ekp" value="[{$ekp}]">
        </li>
        <li>
            <label for="processIdentifier">[{oxmultilang ident="MO_EMPFAENGERSERVICES__PROCESS_IDENTIFIER"}]:</label>
            <select id="processIdentifier" name="processIdentifier">
                <option value="">-</option>
                [{foreach from=$processes key='identifier' item='label'}]
                    <option value="[{$identifier}]"[{if $identifier === $processIdentifier}] selected[{/if}]>
                        [{$label}]
                    </option>
                [{/foreach}]
            </select>
        </li>
        <li>
            <label for="participationNumber">[{oxmultilang ident="MO_EMPFAENGERSERVICES__PARTICIPATION_NUMBER"}]
                :</label>
            <input id="participationNumber" name="participationNumber" maxlength="2"
                   placeholder="[{oxmultilang ident="MO_EMPFAENGERSERVICES__PARTICIPATION_NUMBER"}]"
                   value="[{$participationNumber}]"
            />
        </li>
    </ul>

    <input type="submit" value="[{oxmultilang ident="GENERAL_SAVE"}]"/>
</form>

[{include file="bottomnaviitem.tpl"}]
[{include file="bottomitem.tpl"}]