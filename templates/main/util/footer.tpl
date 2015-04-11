{if $ns.contentLoad == "user_profile" || $ns.contentLoad == "company_profile" || $ns.contentLoad == "user_change_password" || $ns.contentLoad == "company_branches" || $ns.contentLoad == "company_smsconf" || $ns.contentLoad == "company_workingdays"}
{else}
    <div class="clear"></div>
    <div class="footer-wrapper">
        <div class="news-letter-wrapper">
            <div class="container">
                <ul class="socialNetworks-linkes-pages">
                    <li>
                        <a href="https://www.facebook.com/pages/Pcstoream/101732636647846" target="_blank">
                            <div class="img facebook">

                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="https://plus.google.com/111993997426489489686" target="_blank">
                            <div class="img google">

                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="https://www.linkedin.com/company/3743120" target="_blank">
                            <div class="img twitter">

                            </div>
                        </a>
                    </li>
                </ul>
                <div class="news-letter-block">
                    <div id="newsletter_error_message" class="error"></div>
                    <div id="newsletter_success_message" class="success"></div>
                    <div class="input-group">
                        <input id="newsLetterInp" name="" type="text" value="" class="text" placeholder="News letter" >
                        <button class="newsletter_btn" id="newsletterSubscribeBtn"></button>
                        <div class="clear"></div>
                    </div>                
                    {if ($ns.userLevel === $ns.userGroupsGuest)}
                        <div style="display:none;" id="newsLetterAboveBlock" class="news-letter-below-block">
                            <p>Do you want to join us ? <a href="{$SITE_PATH}/signup">Create Account</a></p>
                        </div>
                    {/if}
                </div>
                <div class="clear"></div>
            </div>
        </div>
        <div class="container">
            <div class="footer-nav-content">
                <div class="footer-column">
                    <h5>{$ns.lm->getPhrase(132)}</h5>
                    <a href="/aboutus">
                        <p>{$ns.lm->getPhrase(135)}</p>
                    </a>
                    <a href="/privatepolicy">
                        <p>{$ns.lm->getPhrase(138)}</p>
                    </a>
                </div>
                <div class="footer-column">
                    <h5>{$ns.lm->getPhrase(5)}</h5>
                    {if $ns.userLevel === $ns.userGroupsGuest}
                        <a href="/signup">
                            <p>{$ns.lm->getPhrase(6)}</p>
                        </a>
                    {/if}
                    <a href="/uinvite">
                        <p>{$ns.lm->getPhrase(139)}</p>
                    </a>
                </div>
                <div class="footer-column">
                    <h5>{$ns.lm->getPhrase(134)}</h5>
                    <a href="/contactus">
                        <p>{$ns.lm->getPhrase(46)}</p>
                    </a>
                    <a href="/help">
                        <p>{$ns.lm->getPhrase(140)}</p>
                    </a>
                </div>
            </div>
            <div  class="container">
                <ul class="payments">
                    <li>
                        <img  src="{$SITE_PATH}/img/cash_del_payment.png" />
                    </li>
                    <li>
                        <img  src="{$SITE_PATH}/img/paypal_payment.png" />
                    </li>
                    <li>
                        <img  src="{$SITE_PATH}/img/bank_wire_payment.png" />
                    </li>
                    <li>
                        <img  src="{$SITE_PATH}/img/credit_payment.png" />
                    </li>
                    <li>
                        <img  src="{$SITE_PATH}/img/card_payment.png" />
                    </li>
                </ul>
            </div>
        </div>
    </div>
{/if}



