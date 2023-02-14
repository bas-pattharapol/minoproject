<?php

include_once('database.php');
$db = new database();
?>

<html lang="en" style="height: auto;">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>AdminLTE 3 | Invoice</title>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&amp;display=fallback">

    <link rel="stylesheet" href="static/plugins/fontawesome-free/css/all.min.css">

    <link rel="stylesheet" href="static/dist/css/adminlte.min.css?v=3.2.0">
    <script defer="" referrerpolicy="origin" src="/cdn-cgi/zaraz/s.js?z=JTdCJTIyZXhlY3V0ZWQlMjIlM0ElNUIlNUQlMkMlMjJ0JTIyJTNBJTIyQWRtaW5MVEUlMjAzJTIwJTdDJTIwSW52b2ljZSUyMiUyQyUyMnglMjIlM0EwLjgxMjQ5NDY5MTIxMjk2NCUyQyUyMnclMjIlM0ExNTM2JTJDJTIyaCUyMiUzQTg2NCUyQyUyMmolMjIlM0E3MTQlMkMlMjJlJTIyJTNBMTUzNiUyQyUyMmwlMjIlM0ElMjJodHRwcyUzQSUyRiUyRmFkbWlubHRlLmlvJTJGdGhlbWVzJTJGdjMlMkZwYWdlcyUyRmV4YW1wbGVzJTJGaW52b2ljZS5odG1sJTIyJTJDJTIyciUyMiUzQSUyMmh0dHBzJTNBJTJGJTJGYWRtaW5sdGUuaW8lMkZ0aGVtZXMlMkZ2MyUyRiUyMiUyQyUyMmslMjIlM0EzMCUyQyUyMm4lMjIlM0ElMjJVVEYtOCUyMiUyQyUyMm8lMjIlM0EtNDIwJTJDJTIycSUyMiUzQSU1QiU1RCU3RA=="></script>
    <script nonce="5df290e7-3d40-4bd0-ae63-a571a008d104">
        (function(w, d) {
            ! function(a, e, t, r) {
                a.zarazData = a.zarazData || {};
                a.zarazData.executed = [];
                a.zaraz = {
                    deferred: [],
                    listeners: []
                };
                a.zaraz.q = [];
                a.zaraz._f = function(e) {
                    return function() {
                        var t = Array.prototype.slice.call(arguments);
                        a.zaraz.q.push({
                            m: e,
                            a: t
                        })
                    }
                };
                for (const e of ["track", "set", "debug"]) a.zaraz[e] = a.zaraz._f(e);
                a.zaraz.init = () => {
                    var t = e.getElementsByTagName(r)[0],
                        z = e.createElement(r),
                        n = e.getElementsByTagName("title")[0];
                    n && (a.zarazData.t = e.getElementsByTagName("title")[0].text);
                    a.zarazData.x = Math.random();
                    a.zarazData.w = a.screen.width;
                    a.zarazData.h = a.screen.height;
                    a.zarazData.j = a.innerHeight;
                    a.zarazData.e = a.innerWidth;
                    a.zarazData.l = a.location.href;
                    a.zarazData.r = e.referrer;
                    a.zarazData.k = a.screen.colorDepth;
                    a.zarazData.n = e.characterSet;
                    a.zarazData.o = (new Date).getTimezoneOffset();
                    a.zarazData.q = [];
                    for (; a.zaraz.q.length;) {
                        const e = a.zaraz.q.shift();
                        a.zarazData.q.push(e)
                    }
                    z.defer = !0;
                    for (const e of [localStorage, sessionStorage]) Object.keys(e || {}).filter((a => a.startsWith("_zaraz_"))).forEach((t => {
                        try {
                            a.zarazData["z_" + t.slice(7)] = JSON.parse(e.getItem(t))
                        } catch {
                            a.zarazData["z_" + t.slice(7)] = e.getItem(t)
                        }
                    }));
                    z.referrerPolicy = "origin";
                    z.src = "/cdn-cgi/zaraz/s.js?z=" + btoa(encodeURIComponent(JSON.stringify(a.zarazData)));
                    t.parentNode.insertBefore(z, t)
                };
                ["complete", "interactive"].includes(e.readyState) ? zaraz.init() : a.addEventListener("DOMContentLoaded", zaraz.init)
            }(w, d, 0, "script");
        })(window, document);
    </script>
</head>

<body class="sidebar-mini sidebar-closed sidebar-collapse" style="height: auto;">






    <div class="content-wrapper">

        <?php
        if (isset($_REQUEST['RC_ON'])) {

            $db->query("
            SELECT RC_ON , RC_DATE , RC_TOTAL_PRICE  , CM_NAME  , CM_TEL , CM_EMAIL, AD_DETAILS 
            FROM RECEIPT_TAB , CUSTOMER_TAB , ADDRESS_TAB
            WHERE (RC_FK_CMID = CM_ID AND RC_FK_ADID = AD_ID ) AND  RC_ON = '".$_REQUEST['RC_ON']."' AND RC_STATUS = 'PS003'
            ");
          
            while ($row = $db->getdata()) {

        ?>
                <section class="content">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-12">


                                <div class="invoice p-3 mb-3">

                                    <div class="row">
                                        <div class="col-12">
                                            <h4>
                                                <i class="fas fa-globe"></i> TRIPPLE B, Inc.
                                                <small class="float-right">Date: <?php echo $row["RC_DATE"] ?></small>
                                            </h4>
                                        </div>

                                    </div>

                                    <div class="row invoice-info">
                                        <div class="col-sm-4 invoice-col">
                                            From
                                            <address>
                                                <strong>TRIPPLE B, Inc.</strong><br>
                                                795 Folsom Ave, Suite 600<br>
                                                San Francisco, CA 94107<br>
                                                Phone: (804) 123-5432<br>
                                                Email: info@almasaeedstudio.com
                                            </address>
                                        </div>

                                        <div class="col-sm-4 invoice-col">
                                            To
                                            <address>
                                                <strong><?php echo $row["CM_NAME"] ?></strong><br>
                                                <?php echo $row["AD_DETAILS"] ?><br>
                                               
                                                Phone: <?php echo $row["CM_TEL"] ?><br>
                                                Email: <?php echo $row["CM_EMAIL"] ?>
                                            </address>
                                        </div>

                                        <div class="col-sm-4 invoice-col">
                                            <b>Invoice #<?php echo $row["RC_ON"] ?></b><br>

                                            <b>Payment Due:</b><?php echo $row["RC_DATE"] ?><br>
                                           
                                        </div>

                                    </div>
                                <?php  } ?>

                                <div class="row">
                                    <div class="col-12 table-responsive">
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Serial ID</th>
                                                    <th>Product</th>
                                                    <th>Color</th>
                                                    <th>Size</th>
                                                    <th>Qty</th>
                                                    <th>Subtotal</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php 
                                                 $db->query("
                                                 SELECT SA_ON , SP_ID, SP_NAME , SC_NAME , SS_NAME , SA_AMOUNT , SA_PRICE_TOTAL
                                                FROM SALES_TAB , SHIRT_COLOR_TAB , SHIRT_PRODUCT_TAB , SHIRT_SIZE_TAB
                                                WHERE (SP_ID = SA_FK_PPPD AND SC_ID = SA_FK_PPSC AND SS_ID  = SA_FK_PPSS)  
                                                 AND SA_FK_RCID = '".$_REQUEST['RC_ON']."'
                                                 ");
                                               
                                                 while ($row = $db->getdata()) {
                                     
                                                ?>
                                                <tr>
                                                    <td><?php echo $row["SP_ID"] ?></td>
                                                    <td><?php echo $row["SP_NAME"] ?></td>
                                                    <td><?php echo $row["SC_NAME"] ?></td>
                                                    <td><?php echo $row["SS_NAME"] ?></td>
                                                    <td><?php echo $row["SA_AMOUNT"] ?></td>
                                                    <td><?php echo $row["SA_PRICE_TOTAL"] ?></td>
                                                </tr>
                                               <?php  } ?>
                                            </tbody>
                                        </table>
                                    </div>

                                </div>

                                <div class="row">

                                    <div class="col-6">
                                        <p class="lead">Payment Methods:</p>
                                        <img src="static/dist/img/credit/visa.png" alt="Visa">
                                        <img src="static/dist/img/credit/mastercard.png" alt="Mastercard">
                                        <img src="static/dist/img/credit/american-express.png" alt="American Express">
                                        <img src="static/dist/img/credit/paypal2.png" alt="Paypal">
                                        <p class="text-muted well well-sm shadow-none" style="margin-top: 10px;">
                                            Etsy doostang zoodles disqus groupon greplin oooj voxy zoodles, weebly ning heekya handango imeem
                                            plugg
                                            dopplr jibjab, movity jajah plickers sifteo edmodo ifttt zimbra.
                                        </p>
                                    </div>

                                    <div class="col-6">

                                        <div class="table-responsive">
                                            <table class="table">
                                                <tbody>
                                                    <tr>
                                                        <th style="width:50%">Subtotal:</th>
                                                        <td>$250.30</td>
                                                    </tr>
                                                    <tr>
                                                        <th>DISCOUNT</th>
                                                        <td>$10.34</td>
                                                    </tr>
                                                    
                                                    <tr>
                                                        <th>Total:</th>
                                                        <td>$265.24</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                </div>


                                <div class="row no-print">
                                    <div class="col-12">

                                        <button onclick="window.print()" rel="noopener" target="_blank" class="btn btn-primary float-right" style="margin-right: 5px;">
                                            <i class="fas fa-download"></i> Print Invoice
                                        </button>
                                    </div>
                                </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </section>
            <?php } ?>

    </div>





    <script src="static/plugins/jquery/jquery.min.js"></script>

    <script src="static/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>

    <script src="static/dist/js/adminlte.min.js?v=3.2.0"></script>

    <script src="static/dist/js/demo.js"></script>


</body>

</html>