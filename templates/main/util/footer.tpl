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
                    <div style="display:none;" id="newsLetterAboveBlock" class="news-letter-below-block">
                        <p>Do you want to join us ? <a href="{$SITE_PATH}/signup">Create Account</a></p>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row nav-footer-content">
                <div class="col-md-4 text-center">
                    <h5>Make Money with Us</h5>
                    <a href="/aboutus">
                        <p>About PC Store</p>
                    </a>
                    <a href="/privatepolicy">
                        <p>Private Policy</p>
                    </a>
                </div>
                <div class="col-md-4 text-center">
                    <h5>Make Money with Us</h5>
                    <a href="/signup">
                        <p>Registration</p>
                    </a>
                    <a href="#">
                        <p>Invite Friends</p>
                    </a>
                </div>
                <div class="col-md-4 text-center">
                    <h5>Let Us Help You</h5>
                    <a href="/contactus">
                        <p>Contact Us </p>
                    </a>
                    <a href="/help">
                        <p>Help</p>
                    </a>
                </div>
            </div>
            <div class="row">
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
    </div>
{/if}



