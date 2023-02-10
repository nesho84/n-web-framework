<div id="cardForm" class="px-0">
    <!-- Errors Output -->
    <div id="contact_result"></div>

    <div class="card card-body bg-light">
        <div class="d-flex flex-wrap justify-content-between">
            <div class="text-muted">
                <i class="fas fa-envelope"></i>
                <small class="pl-1"><strong>E-Mail:</strong> <a href="mailto:office@company.com">office@company.com</a></small>
            </div>
            <div class="text-muted">
                <i class="fas fa-map-marker-alt"></i>
                <small class="pl-1"><strong>Address: </strong>Address
                    postalcode, Country</small>
            </div>
        </div>
        <hr />
        <small class="text-muted mb-2 mx-auto">Bitte füllen Sie alle Pflichtfelder (*) aus.</small>

        <form id="contactForm" action="<?php echo APPURL . '/contact/validate'; ?>" method="POST">
            <div class="mb-3">
                <label for="name">Name: <sup>*</sup></label>
                <input type="text" name="name" class="form-control form-control-lg" />
            </div>
            <div class="mb-3">
                <label for="company">Unternehmen: <sup>*</sup></label>
                <input type="text" name="company" class="form-control form-control-lg" />
            </div>
            <div class="mb-3">
                <label for="telefon">Telefon: </label>
                <input type="tel" name="telefon" class="form-control form-control-lg" pattern="[0-9]+" />
            </div>
            <div class="mb-3">
                <label for="email">Email: <sup>*</sup></label>
                <input type="email" name="email" class="form-control form-control-lg" />
                <small id="emailHelp" class="form-text text-muted">Wir werden Ihre E-Mail-Adresse niemals an Dritte weitergeben.</small>
            </div>
            <div class="mb-3">
                <label for="subject">Betreff: <sup>*</sup></label>
                <textarea name="subject" class="form-control form-control-lg" rows="3"></textarea>
            </div>
            <div class="form-check">
                <input type="checkbox" class="form-check-input" name="policy" value="ok">
                <label class="form-check-label" for="policy">
                    Sie erklären sich damit einverstanden, dass Ihre Daten zur Bearbeitung Ihres Anliegens verwendet werden. Weitere Informationen und Widerrufshinweise finden Sie in der
                    <a href="https://en.wikipedia.org/wiki/Privacy_policy" target="_blank" class="text-info">Datenschutz-Bestimmungen. </a><sup>*</sup>
                </label>
            </div>
            <div class="mb-3 mt-4">
                <div class="g-recaptcha" data-sitekey="6LdEqsEfAAAAAHU-sWZpR6e__utvS1hROogeeX-K">
                </div>
            </div>
            <div class="row mt-4">
                <div class="col">
                    <div class="d-grid gap-2">
                        <input type="hidden" id="submited" name="submited">
                        <button type="submit" name="senden" class="btn btn-success btn-block">SUBMIT <i class="fas fa-paper-plane ml-1"></i></button>
                    </div>
                </div>
            </div>
        </form>

    </div>
</div>

<!-- Contact Form Handler -->
<script src="<?php echo APPURL ?>/public/js/contact.js"></script>
<!-- Google reCAPTCHA API -->
<script src="https://www.google.com/recaptcha/api.js" async defer></script>