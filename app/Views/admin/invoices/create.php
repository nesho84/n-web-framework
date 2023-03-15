<!-- Page Header -->
<?php showHeading(['title' => 'Create Invoice']); ?>

<div class="container-lg">
    <div class="card">
        <div class="card-body">
            <form id="formInvoices" action="<?php echo ADMURL . '/invoices/insert'; ?>" method="POST" enctype="multipart/form-data">

                <!-- Company -->
                <div class="card">
                    <div class="card-body">
                        <h4>Company Information</h4>
                        <hr class="mt-1">
                        <div class="mb-3">
                            <label for="companyName" class="form-label fw-bold">Company Name</label>
                            <input type="text" class="form-control" id="companyName" name="companyName" placeholder="Company Name" value="<?php echo $_SESSION['inputs']['companyName'] ?? ""; ?>">
                        </div>
                    </div>
                </div>

                <!-- Services -->
                <div class="card my-3">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between">
                            <h4>Services</h4>
                            <button type="button" class="btn btn-sm btn-success" onclick="addService()">Add Service +</button>
                        </div>
                        <hr class="mt-1">
                        <div id="services">
                            <div class="service bg-light position-relative border px-2 pb-2 pt-5">
                                <h5 class="service-number border-bottom position-absolute top-0 start-0 p-1">
                                    #<span class="service-count">1</span>
                                </h5>
                                <div class="mb-3">
                                    <label for="serviceName" class="form-label fw-bold">Service Name</label>
                                    <input type="text" class="form-control" id="serviceName" name="services[0][serviceName]" placeholder="Service Name" value="<?php echo $_SESSION['inputs']['serviceName'] ?? ""; ?>">
                                </div>
                                <div class="mb-3">
                                    <label for="serviceDescription" class="form-label fw-bold">Service Description (optional)</label>
                                    <textarea class="form-control" rows="2" id="serviceDescription" name="services[0][serviceDescription]" placeholder="Service Description"><?php echo $_SESSION['inputs']['serviceDescription'] ?? ""; ?></textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="servicePrice" class="form-label fw-bold">Service Price</label>
                                    <input type="number" step="0.00" class="form-control" id="servicePrice" name="services[0][servicePrice]" placeholder="Service Price" value="<?php echo $_SESSION['inputs']['servicePrice'] ?? ""; ?>">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Buttons -->
                <div class="d-grid gap-2 d-md-block text-end border-top border-2 py-2">
                    <button type="submit" id="insert_invoice" name="insert_invoice" class="btn btn-primary btn-lg me-1">Save</button>
                    <a href="<?php echo ADMURL . "/invoices"; ?>" type="button" class="btn btn-secondary btn-lg">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    let sCounter = Number(document.querySelector('.service-count').textContent);
    let sIndex = 0;

    function addService() {
        sCounter++;
        sIndex++;
        const services = document.getElementById('services');
        const serviceDiv = document.createElement('div');
        serviceDiv.classList.add('service');
        serviceDiv.innerHTML = `
        <div class="service bg-light position-relative border px-2 pb-2 pt-5 mt-3">
            <h5 class="service-number border-bottom position-absolute top-0 start-0 p-1">
                #<span class="service-count">${sCounter}</span>
            </h5>
            <div class="mb-3">
                <label for="serviceName${sIndex}" class="form-label fw-bold">Service Name</label>
                <input type="text" class="form-control" id="serviceName${sIndex}" name="services[${sIndex}][serviceName]" placeholder="Service Name" value="">
            </div>
            <div class="mb-3">
                <label for="serviceDescription${sIndex}" class="form-label fw-bold">Service Description (optional)</label>
                <textarea class="form-control" rows="2" id="serviceDescription${sIndex}" name="services[${sIndex}][serviceDescription]" placeholder="Service Description"></textarea>
            </div>
            <div class="mb-3">
                <label for="servicePrice${sIndex}" class="form-label fw-bold">Service Price</label>
                <input type="number" step="0.00" class="form-control" id="servicePrice${sIndex}" name="services[${sIndex}][servicePrice]" placeholder="Service Price" value="">
            </div>
        </div>
        `;
        services.appendChild(serviceDiv);
    }
</script>