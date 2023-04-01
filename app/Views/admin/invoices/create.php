<!-- Page Header -->
<?php showHeading(['title' => 'Create Invoice']); ?>

<div class="container-lg">
    <div class="card">
        <div class="card-body">
            <form id="formInvoices" action="<?php echo ADMURL . '/invoices/insert'; ?>" method="POST" enctype="multipart/form-data">

                <!-- Company Information -->
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between">
                            <h4>Company Information</h4>
                            <button type="button" id="btn-add-company" class="btn btn-sm btn-success">Add Company +</button>
                        </div>
                        <hr class="mt-1">

                        <!-- Select Company -->
                        <div class="mb-3">
                            <label for="companyID" class="form-label fw-bold">Company</label>
                            <select id="companyID" name="companyID" class="form-select form-select-sm">
                                <option class="select_hide" disabled selected>Select Company</option>
                                <?php
                                $compArray = $data['companies'];
                                foreach ($compArray as $comp) {
                                    if ($comp['companyID'] == ($_SESSION['inputs']['companyID'] ?? "")) {
                                        $selected = "selected";
                                    } else {
                                        $selected = "";
                                    }
                                    echo "<option value='{$comp['companyID']}' $selected>{$comp['companyName']}</option>";
                                }
                                ?>
                            </select>
                        </div>

                        <!-- Create New Company -->
                        <div id="new-company-group" class="mb-3 border p-2" style="display: none;">
                            <div class="mb-3">
                                <label for="companyName" class="form-label fw-bold">Company Name</label>
                                <input type="text" class="form-control form-control-sm" id="companyName" name="companyName" value="<?php echo $_SESSION['inputs']['company']['companyName'] ?? ""; ?>">
                            </div>
                            <div class="mb-3">
                                <label for="companyAddress" class="form-label fw-bold">Address</label>
                                <input type="text" class="form-control form-control-sm" id="companyAddress" name="companyAddress" value="<?php echo $_SESSION['inputs']['company']['companyAddress'] ?? ""; ?>">
                            </div>
                            <div class="mb-3">
                                <label for="companyCity" class="form-label fw-bold">City</label>
                                <input type="text" class="form-control form-control-sm" id="companyCity" name="companyCity" value="<?php echo $_SESSION['inputs']['company']['companyCity'] ?? ""; ?>">
                            </div>
                            <div class="mb-3">
                                <label for="companyState" class="form-label fw-bold">State</label>
                                <input type="text" class="form-control form-control-sm" id="companyState" name="companyState" value="<?php echo $_SESSION['inputs']['company']['companyState'] ?? ""; ?>">
                            </div>
                            <div class="mb-3">
                                <label for="companyZip" class="form-label fw-bold">Zip</label>
                                <input type="text" class="form-control form-control-sm" id="companyZip" name="companyZip" value="<?php echo $_SESSION['inputs']['company']['companyZip'] ?? ""; ?>">
                            </div>
                            <div class="mb-3">
                                <label for="companyPhone" class="form-label fw-bold">Phone</label>
                                <input type="text" class="form-control form-control-sm" id="companyPhone" name="companyPhone" value="<?php echo $_SESSION['inputs']['company']['companyPhone'] ?? ""; ?>">
                            </div>
                            <div class="">
                                <label for="companyEmail" class="form-label fw-bold">Email</label>
                                <input type="text" class="form-control form-control-sm" id="companyEmail" name="companyEmail" value="<?php echo $_SESSION['inputs']['company']['companyEmail'] ?? ""; ?>">
                            </div>
                            <!-- Company type -->
                            <input type="hidden" name="company-type" id="company-type" value="existing">
                        </div>
                        <div class="">
                            <label for="invoiceTotalPrice" class="form-label fw-bold">Total Price</label>
                            <input type="number" step="0.00" class="form-control form-control-sm" id="invoiceTotalPrice" name="invoiceTotalPrice" placeholder="" value="">
                        </div>
                    </div>
                </div>

                <!-- Services -->
                <div class="card my-3">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between">
                            <h4>Services</h4>
                            <button type="button" id="btn-add-service" class="btn btn-sm btn-success">Add Service +</button>
                        </div>
                        <hr class="mt-1">
                        <div id="services" class="overflow-auto" style="max-height: 350px;">
                            <div class="service bg-light position-relative border px-2 pb-2 pt-5">
                                <h5 class="service-number border-bottom position-absolute top-0 start-0 m-0 p-1">
                                    #<span class="service-count">1</span>
                                </h5>
                                <div class="border-bottom position-absolute top-0 end-0" style="color: #dc3545; padding: 4px; cursor: pointer;">
                                    <i class="deleteService fas fa-trash-alt"></i>
                                </div>
                                <div class="row gy-2 gx-3 align-items-center">
                                    <div class="col-sm-4">
                                        <label for="serviceName_0" class="form-label fw-bold">Name</label>
                                        <input type="text" class="form-control form-control-sm" id="serviceName_0" name="services[0][serviceName]" value="">
                                    </div>
                                    <div class="col-sm-4">
                                        <label for="serviceDescription_0" class="form-label fw-bold">Description</label>
                                        <textarea class="form-control form-control-sm" rows="1" id="serviceDescription_0" name="services[0][serviceDescription]"></textarea>
                                    </div>
                                    <div class="col-sm-2">
                                        <label for="serviceQuantity_0" class="form-label fw-bold">Quantity</label>
                                        <input type="number" class="service-quantity form-control form-control-sm" id="serviceQuantity_0" name="services[0][serviceQuantity]" value="">
                                    </div>
                                    <div class="col-sm-2">
                                        <label for="servicePrice_0" class="form-label fw-bold">Price</label>
                                        <input type="number" step="0.00" class="service-price form-control form-control-sm" id="servicePrice_0" name="services[0][servicePrice]" value="">
                                    </div>
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
    'use strict';

    // Services
    const btnAddService = document.getElementById('btn-add-service');
    const services = document.getElementById('services');
    let sIndex = 0;
    // Company
    const btnAddCompany = document.getElementById('btn-add-company');
    const newCompanyGroup = document.getElementById('new-company-group');
    const companySelect = document.getElementById('companyID');
    const companyTypeInput = document.getElementById('company-type');
    // Form
    const form = document.querySelector("#formInvoices");

    document.addEventListener('DOMContentLoaded', function() {
        // Add new Company
        btnAddCompany.addEventListener('click', addCompany);
        // Select Company
        companySelect.addEventListener('change', selectCompany);

        // Add new Service
        btnAddService.addEventListener('click', addService);
        // Delete Service
        services.addEventListener('click', deleteService);

        // Set/Refresh Total Price
        setTotalPrice();

        // Attach the submit event handler to the form (ajax.js)
        form.addEventListener("submit", handleSubmit);
    });

    function addCompany() {
        newCompanyGroup.style.display = newCompanyGroup.style.display === 'none' ? 'block' : 'none';
        companySelect.selectedIndex = 0; // reset the select input
        companyTypeInput.value = 'new'; // set the company type to 'new'
    }

    function selectCompany() {
        newCompanyGroup.style.display = 'none';
        companyTypeInput.value = 'existing'; // set the company type to 'existing'
    }

    function addService() {
        sIndex++;

        const serviceDiv = document.createElement('div');
        serviceDiv.classList.add('service');
        serviceDiv.innerHTML = `
        <div class="bg-light position-relative border px-2 pb-2 pt-5 mt-2">
            <h5 class="service-number border-bottom position-absolute top-0 start-0 m-0 p-1">
                #<span class="service-count">2</span>
            </h5>
            <div class="border-bottom position-absolute top-0 end-0" style="color: #dc3545; padding: 4px; cursor: pointer;">
                <i class="deleteService fas fa-trash-alt"></i>
            </div>
            <div class="row gy-2 gx-3 align-items-center">
                <div class="col-sm-4">
                    <label for="serviceName_${sIndex}" class="form-label fw-bold">Name</label>
                    <input type="text" class="form-control form-control-sm" id="serviceName_${sIndex}" name="services[${sIndex}][serviceName]" value="">
                </div>
                <div class="col-sm-4">
                    <label for="serviceDescription_${sIndex}" class="form-label fw-bold">Description</label>
                    <textarea class="form-control form-control-sm" rows="1" id="serviceDescription_${sIndex}" name="services[${sIndex}][serviceDescription]"></textarea>
                </div>
                <div class="col-sm-2">
                    <label for="serviceQuantity_${sIndex}" class="form-label fw-bold">Quantity</label>
                    <input type="number" class="service-quantity form-control form-control-sm" id="serviceQuantity_${sIndex}" name="services[${sIndex}][serviceQuantity]">
                </div>
                <div class="col-sm-2">
                    <label for="servicePrice_${sIndex}" class="form-label fw-bold">Price</label>
                    <input type="number" step="0.00" class="service-price form-control form-control-sm" id="servicePrice_${sIndex}" name="services[${sIndex}][servicePrice]">
                </div>
            </div>
        </div>
        `;
        services.appendChild(serviceDiv);
        serviceDiv.scrollIntoView(false);

        // Update Service Counter
        updateServiceCounter();
        // Set/Refresh Total Price
        setTotalPrice();
    }

    function deleteService(event) {
        if (event.target.classList.contains('deleteService')) {
            event.target.closest('.service').remove();
            // Update Service Counter
            updateServiceCounter();
            // Set/Refresh Total Price
            setTotalPrice();
        }
    }

    function updateServiceCounter() {
        // Update # counter
        const serviceCount = document.querySelectorAll('.service-count');
        serviceCount.forEach(function(item, index) {
            if (item !== null) {
                item.textContent = index + 1;
            }
        });
    }

    function calculateTotalPrice() {
        let total = 0;
        document.querySelectorAll(".service").forEach(function(row) {
            let quantityInput = row.querySelector(".service-quantity");
            let quantity = parseFloat(row.querySelector(".service-quantity").value);
            let price = parseFloat(row.querySelector(".service-price").value);
            if (isNaN(quantity) || quantity < 1) {
                quantity = 1;
                quantityInput.value = 1;
            }
            if (isNaN(price) || price.length === 0) {
                price = 0;
            }
            total += quantity * price;
        });
        document.getElementById('invoiceTotalPrice').value = total.toFixed(2);
    }

    function setTotalPrice() {
        calculateTotalPrice();
        document.querySelectorAll(".service").forEach(function(input) {
            input.addEventListener("input", function() {
                // Calculate also on input event
                calculateTotalPrice();
            });
        });
    }
</script>