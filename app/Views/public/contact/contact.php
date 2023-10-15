<section class="container-lg py-4">
    <div id="success">
        <!-- Google Maps Section START -->
        <div class="row mb-4 mx-0 px-2 py-3 border">
            <div class="col-12 col-sm-6">
                <p class="lead">
                    <?php
                    // if (isset($data['page']['pageContent'])) {
                    //     echo $data['page']['pageContent'];
                    // }
                    ?>

                    <span><i class="fas fa-map-marker-alt"></i></span><br />
                    <span>company</span><br />
                    <span>address,</span> <br />
                    <span>postalcode city</span> <br />
                    <span>Country</span> <br /><br />

                    <i class="fas fa-phone-square-alt"></i><strong class="pl-1">Tel: </strong><a href="tel:+00 000 00 00 00">+00 000 00 00 00</a><br />
                    <i class="fas fa-phone-square-alt"></i><strong class="pl-1">Tel: </strong><a href="tel:+00 000 00 00 00">+00 000 00 00 00</a><br />
                    <i class="fas fa-envelope"></i><small class="pl-1"><strong>E-Mail:</strong> <a href="mailto:office@company.com">office@company.com</a></small>
                </p>
            </div>
            <div class="col-12 col-sm-6">
                <iframe loading="lazy" width="100%" height="100%" allowfullscreen src="https://www.google.com/maps/embed/v1/place?q=place_id:ChIJVVVl1vynbUcRlJnRXQvkBnI&key=AIzaSyCoyUx7XyXlHPKt1nuU8Of8_HmMgtEAYXY"></iframe>
            </div>
        </div> <!-- Google Maps Section END -->

        <div class="row g-4" id="focus-div">
            <div class="col-12">
                <hr class="mt-0" />
                <h4 class="font-weight-bold text-center">Contact Us</h4>
                <hr class="mb-4" />
                <!-- Contact Form -->
                <?php require_once "contact_form.php"; ?>
            </div>
        </div>
    </div>
</section>