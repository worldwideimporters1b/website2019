<?php
include 'head.php';
include 'header.php';


$contactinfo = '<ul class="list-unstyled mb-0">
                <li><i class="fas fa-map-marker-alt fa-2x"></i>
                    <p>Wide World Importers<br>Groothandelstraat 115<br>1111AA<br>Zwolle</p>
                </li>

                <li><i class="fas fa-phone mt-4 fa-2x"></i>
                    <p>+31 6 123 456 78</p>
                </li>

                <li><i class="fas fa-envelope mt-4 fa-2x"></i>
                    <p>contact@worldwideimporters.nl</p>
                </li>
            </ul>';
?>
<body>
<div class="container">
    <h3>Contact</h3>

    <p>Heeft u vragen en/of opmerking aan ons? Via het onderstaande formulier kunt u via de mail contact met ons opnemen, WIj zullen zo spoedig mogelijk uw vragen beantwoorden.</p>

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

 <?php echo $contactinfo; ?>       <div class="col-md-3 text-right">
<$contactinfo
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
</form><br><br>

<div class="status"></div>
</div>


<div class="col-md-3 text-right">
<?php echo $contactinfo; ?>
</div>
<br><br>
<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2431.6978911624606!2d6.125448916169112!3d52.4483872298006!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47c7ddd206af1103%3A0xd1c8109f9c7727d2!2sWindesheim%2C%20Zwolle!5e0!3m2!1sen!2snl!4v1578837024015!5m2!1sen!2snl" width="100%" height="350" frameborder="0" style="border:0;" allowfullscreen=""></iframe>

<?php } ?>
</div>



