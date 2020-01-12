<?php
include 'head.php';
include 'header.php';
?>
<body>
<div class="container">
    <h2 class="h1-responsive font-weight-bold text-center my-4">Contact</h2>

    <p class="text-center w-responsive mx-auto mb-5">Heeft u vragen en/of opmerking aan ons? Via het onderstaande
        formulier kunt u via de mail contact met ons opnemen, wij zullen zo spoedig mogelijk uw vragen beantwoorden.</p>

    <div class="row">

        <div class="col-md-9 mb-md-0 mb-5">
            <form id="contact-form" name="contact-form" action="contact.php" method="POST">
                <div class="row">
                    <?php if (!isset($_SESSION['ingelogd'])) {  //wanneer je niet bent ingelogd, verschijnt het email veld.
                    ?>
                    <div class="col-md-12">
                        <div class="md-form mb-0">
                            <input type="text" id="email" name="email" class="form-control" required>
                            <label for="email" class="">Uw email</label>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="md-form mb-0">
                            <input type="text" id="name" name="name" class="form-control" required>
                            <label for="name" class="">Uw naam</label>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="md-form mb-0">
                            <input type="text" id="subject" name="subject" class="form-control">
                            <label for="subject" class="">Onderwerp</label>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="md-form">
                            <textarea type="text" id="message" name="message" rows="2"
                                      class="form-control md-textarea"></textarea>
                            <label for="message">Bericht</label>
                        </div>

                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Verstuur</button>
            </form>
            <div class="status"></div>
        </div>

        <div class="col-md-3 text-center">
            <ul class="list-unstyled mb-0">
                <li><i class="fas fa-map-marker-alt fa-2x"></i>
                    <p>Nederland, 1111AA , Zwolle</p>
                </li>

                <li><i class="fas fa-phone mt-4 fa-2x"></i>
                    <p>+31 6 123 456 78</p>
                </li>

                <li><i class="fas fa-envelope mt-4 fa-2x"></i>
                    <p>contact@worldwideimporters.nl</p>
                </li>
            </ul>
        </div>
    </div>

    <?php } //anders hoef je geen emailadres en naam in te voeren.
    else{ ?>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="md-form mb-0">
            <input type="text" id="subject" name="subject" class="form-control" required>
            <label for="subject" class="">Onderwerp</label>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="md-form">
                            <textarea type="text" id="message" name="message" rows="2"
                                      class="form-control md-textarea"></textarea>
            <label for="message">Bericht</label>
        </div>

    </div>
</div>

<button type="submit" class="btn btn-primary">Verstuur</button>
</form>
<div class="status"></div>
</div>


<div class="col-md-3 text-center">
    <ul class="list-unstyled mb-0">
        <li><i class="fas fa-map-marker-alt fa-2x"></i>
            <p>Nederland, 1111AA , Zwolle</p>
        </li>

        <li><i class="fas fa-phone mt-4 fa-2x"></i>
            <p>+31 6 123 456 78</p>
        </li>

        <li><i class="fas fa-envelope mt-4 fa-2x"></i>
            <p>contact@wideworldimporters.nl</p>
        </li>
    </ul>
</div>

</div>
<?php } ?>
</div>
</body>


