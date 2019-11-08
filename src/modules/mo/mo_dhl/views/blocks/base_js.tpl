[{$smarty.block.parent}]
[{if method_exists($oView,'mo_dhl__showTrackingPixel') && $oView->moDHLShowTrackingPixel()}]
    <script type="application/javascript">
        <!--
        s_date = new Date();
        s_rdm = s_date.getTime();
        s_url = escape(window.location.host);
        s_desturl = '<img width="1" height="1" src="' + window.location.protocol + '//deutschepostag.112.2o7.net/b/ss/deutschepostdhlpaketprod/1/H.27.5--NS/' + s_rdm + '?events=event80&v80=' + s_url + '" />';
        document.write(s_desturl);
        //-->
    </script>
[{/if}]
