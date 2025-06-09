<?php
    include 'cardarray.php';
?>
<?php include 'include/header.php'; ?>
<header>
    <?php include 'include/navbar.php'; ?>
</header>

<!--Body area here -->
<main>
    <section>
        <div class="container-fluid mt-3">
            <div class="row">
                <div class="col-5">
                    <div class="home-title">
                        <a href="" style="font-size: 25px; border-right: 0.1px solid #313131; padding-right: 20px;">Dashboard</a>
                        <a href="javascript:void(0)" style="margin-left: 20px; font-family: 'Exo 2';"><i class="fas fa-home" style="padding-right: 5px;"></i> Anlysis</a>
                    </div>
                </div> 
                <div class="col-12 col-md-7">
                    <div class="total-print d-flex justify-content-between">
                        <a href="javascript:void(0)" style="margin-left: 20px; font-family: 'Exo 2';"> Total Amount <?= date('F Y') ?> <i class="fas fa-arrow-right" style="font-size: 13px; padding-left: 5px; padding-right: 5px;"></i> <span style="color: #4CAF50;"><b>[ 00 ]</b></span></a>
                        <a href="javascript:void(0)" style="margin-left: 20px; font-family: 'Exo 2';"> Total Amount Till Now <i class="fas fa-arrow-right" style="font-size: 13px; padding-left: 5px; padding-right: 5px;"></i> <span style="color: #FF4545;"><b>[ 00 ]</b></span></a>
                    </div>
                </div>   
            </div>
            <div class="row">
                <?php
                    foreach($cards as $card){
                ?>
                    <div class="col-lg-3 col-md-6 col-sm-12">
                        <a href="javascript:void(0)">
                            <div class="home-card" style="background-color:<?= $card['card-color']; ?>;">
                                <div class="home-card-left">
                                    <i class="<?= $card['icon']; ?>" style="color:<?= $card['color']; ?>; background-color: <?= $card['bg-color']; ?>;"></i>
                                </div>
                                <div class="home-card-right">
                                    <div style="display: block; float: right;">
                                        <div class="num" data-target="<?= $card['num']; ?>" style="color:<?= $card['num-color']; ?>">0</div>
                                        <div class="title" style="color: <?= $card['num-color']; ?>;">
                                            <?= $card['title']; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div> 
                <?php
                    }
                ?>   
            </div>
        </div>
    </section>
</main>
<!--Body Section -->

<?php include 'include/footer.php'; ?>
