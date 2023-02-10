<div class="container-lg">
    <section class="text-lg-left py-4">
        <!-- <hr class="mt-0" />
        <h2 class="font-weight-bold">About Us</h2>
        <hr /> -->
        <br>
        <?php
        if (isset($data['page']['pageContent'])) {
            echo $data['page']['pageContent'];
        }
        ?>
    </section>
    <!-- test ajax -->
    <button id="btnAjax" class="btn btn-success mb-3">ajax test</button>
    <div id="content" class="p-4 border"></div>
</div>

<script>
    document.getElementById('btnAjax').addEventListener('click', async () => {
        try {
            const response = await fetch(`<?php echo APPURL . '/ajax_test' ?>`);
            const data = await response.json();

            console.log(data);

            document.getElementById('content').innerHTML = `
            <p>Page Title: <strong>${data.pageTitle}</strong></p>
            <p>PageMetaDescription: <strong>${data.PageMetaDescription}</strong></p>
            <p>PageMetaKeywords: <strong>${data.PageMetaKeywords}</strong></p>
            <p>PageMetaTitle: <strong>${data.PageMetaTitle}</strong></p>
            <p>Page Content: <strong>${data.pageContent}</strong></p>`;
        } catch (error) {
            console.log(`Error: ${error}`);
        }

    });
</script>