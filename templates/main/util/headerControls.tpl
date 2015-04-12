<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<meta charset="UTF-8">
<link rel="shortcut icon" type="image/png" href="{$SITE_PATH}/img/favico.png" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

{if isset($ns.page_title)}
    <meta content="{$ns.page_title}" name="title">
    <title>{$ns.page_title}</title>
{/if}
{if isset($ns.page_description)}
    <meta content="{$ns.page_description}" name="description">
{/if}
{if isset($ns.page_keywords)}
    <meta content="{$ns.page_keywords}" name="keywords">
{/if}

<!-- NGS Theme Styles -->
<link rel="stylesheet" type="text/css" href="{$SITE_PATH}/css/jquery/jquery-ui.css?{$VERSION}" />
<link rel="stylesheet" type="text/css" href="{$SITE_PATH}/css/jquery/jquery.ui.accordion.css?{$VERSION}" />
<link rel="stylesheet" type="text/css" href="{$SITE_PATH}/css/jquery/jquery.ui.dialog.css?{$VERSION}" />
<link rel="stylesheet" type="text/css" href="{$SITE_PATH}/css/jquery/jquery.ui.theme.css?{$VERSION}" />
<link rel="stylesheet" type="text/css" href="{$SITE_PATH}/css/main/style.css?{$VERSION}" />
<link rel="stylesheet" type="text/css" href="{$SITE_PATH}/css/main/skin.css?{$VERSION}" />
{*<link rel="stylesheet" type="text/css" href="{$SITE_PATH}/css/main/responsive.css?{$VERSION}" />*}
<link rel="stylesheet" type="text/css" href="{$SITE_PATH}/css/main/left_panel.css?{$VERSION}" />
<link rel="stylesheet" type="text/css" href="{$SITE_PATH}/css/main/fonts.css?{$VERSION}" />
{*}
<link rel="stylesheet" type="text/css" href="{$SITE_PATH}/css/main/bootstrap-theme.css?{$VERSION}" />
<link rel="stylesheet" type="text/css" href="{$SITE_PATH}/css/main/bootstrap.css?{$VERSION}" />
{*}
<link rel="stylesheet" type="text/css" href="{$SITE_PATH}/css/customscroll/jquery.mCustomScrollbar.css?" />


<link rel="stylesheet" type="text/css" href="{$SITE_PATH}/css/main/owl.carousel.css?{$VERSION}" />
<link rel="stylesheet" type="text/css" href="{$SITE_PATH}/css/main/owl.theme.css?{$VERSION}" />
<link rel="stylesheet" type="text/css" href="{$SITE_PATH}/css/main/owl.transitions.css?" />
{if $ns.userLevel === $ns.userGroupsAdmin}
    <link rel="stylesheet" type="text/css" href="{$SITE_PATH}/js/lib/jtree/themes/default/style.min.css?{$VERSION}" />
{/if}

<script type="text/javascript">
    {literal}
        var ngs = {
        };
    {/literal}	        
        var SITE_URL = "{$SITE_URL}";
        var SITE_PATH = "{$SITE_PATH}";
        var customer_ping_pong_timeout_seconds = {$ns.customer_ping_pong_timeout_seconds};
</script>


<script type="text/javascript"  src="{$SITE_PATH}/js/lib/prototype.js" ></script>
<script type="text/javascript"  src="{$SITE_PATH}/js/lib/jquery/jquery.js" ></script>
<script type="text/javascript"  src="{$SITE_PATH}/js/lib/jquery/jquery.mobile.custom.min.js" ></script>
<script type="text/javascript"  src="{$SITE_PATH}/js/lib/jquery/jquery-ui-1.9.2.js"></script>
<script type="text/javascript" src="{$SITE_PATH}/js/lib/tinymce4/tinymce/js/tinymce/tinymce.js"></script>
<script type="text/javascript" src="{$SITE_PATH}/js/lib/customscroll/jquery.mCustomScrollbar.concat.min.js"></script>
<script type="text/javascript" src="{$SITE_PATH}/js/lib/customscroll/jquery.mCustomScrollbar.js"></script>
<script type="text/javascript"  src="{$SITE_PATH}/js/lib/owl.carousel.js"></script>
{if $ns.userLevel === $ns.userGroupsAdmin}
    <script type="text/javascript"  src="{$SITE_PATH}/js/lib/jtree/jstree.min.js"></script>
{/if}

<script type="text/javascript">
    jQuery.noConflict();
</script>

<script type="text/javascript" src="{$SITE_PATH}/js/out/ngs.js?4_2_6"></script>
<script type="text/javascript" src="{$SITE_PATH}/js/out/ngs_loads.js?4_2_6"></script>
<script type="text/javascript" src="{$SITE_PATH}/js/out/ngs_util.js?4_2_6"></script>
<script type="text/javascript" src="{$SITE_PATH}/js/out/ngs_actions.js?4_2_6"></script>
<script type="text/javascript" src="{$SITE_PATH}/js/out/ngs_manager.js?4_2_6"></script>



{* facebook login setup *}
<script type="text/javascript"  src="//connect.facebook.net/en_US/sdk.js"></script>
{* linkedin login setup *}
<script type="text/javascript" src="//platform.linkedin.com/in.js">
    api_key: 75ys1q9fcupeqq
    authorize: true
</script> 
{* google pluse login setup *}
<script type="text/javascript" src="https://apis.google.com/js/client:plusone.js"></script>
<meta name="google-signin-clientid" content="1035369249-j8j8uc4oacruo2iefonhdj1q0csjb9sj.apps.googleusercontent.com" />
<meta name="google-signin-scope" content="https://www.googleapis.com/auth/plus.login  https://www.google.com/m8/feeds" />
<meta name="google-signin-requestvisibleactions" content="http://schema.org/AddAction" />
<meta name="google-signin-cookiepolicy" content="single_host_origin" />
<meta name="google-signin-callback" content="googleLoginCallback" />


{literal}
    <script>
                (function (i, s, o, g, r, a, m) {
                    i['GoogleAnalyticsObject'] = r;
                    i[r] = i[r] || function () {
                        (i[r].q = i[r].q || []).push(arguments);
                    }, i[r].l = 1 * new Date();
                    a = s.createElement(o),
                            m = s.getElementsByTagName(o)[0];
                    a.async = 1;
                    a.src = g;
                    m.parentNode.insertBefore(a, m);
                })(window, document, 'script', '//www.google-analytics.com/analytics.js', 'ga');
        ga('create', 'UA-61087329-3', 'auto');
        ga('send', 'pageview');
    </script>
{/literal}