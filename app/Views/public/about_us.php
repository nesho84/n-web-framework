<div class="container-lg">
    <section class="text-lg-left py-4">
        <!-- <hr class="mt-0" />
        <h2 class="font-weight-bold">About Us</h2>
        <hr /> -->
        <?php
        if (isset($data['page']['pageContent'])) {
            echo $data['page']['pageContent'];
        }
        ?>
    </section>
</div>