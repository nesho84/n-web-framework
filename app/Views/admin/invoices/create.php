<!-- Page Header -->
<?php showHeading(['title' => 'Create Invoice']); ?>

<div class="container-lg">
    <div class="card">
        <div class="card-body">
            <form id="formInvoices" action="<?php echo ADMURL . '/invoices/insert'; ?>" method="POST" enctype="multipart/form-data">

                <!-- Company -->
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between">
                            <h4>Company Information</h4>
                            <button type="button" id="add-company-btn" class="btn btn-sm btn-success">Add Company +</button>
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
                            <input type="number" step="0.00" class="form-control form-control-sm" id="invoiceTotalPrice" name="invoiceTotalPrice" placeholder="this will be dynamic, the sum of services price" value="">
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
                                        <label for="serviceName" class="form-label fw-bold">Service Name</label>
                                        <input type="text" class="form-control form-control-sm" id="serviceName" name="services[0][serviceName]" value="">
                                    </div>
                                    <div class="col-sm-5">
                                        <label for="serviceDescription" class="form-label fw-bold">Service Description</label>
                                        <textarea class="form-control form-control-sm" rows="1" id="serviceDescription" name="services[0][serviceDescription]"></textarea>
                                    </div>
                                    <div class="col-sm-3">
                                        <label for="servicePrice" class="form-label fw-bold">Service Price</label>
                                        <input type="number" step="0.00" class="service-price form-control form-control-sm" id="servicePrice" name="services[0][servicePrice]" value="">
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
    const services = document.getElementById('services');
    let sCounter = Number(document.querySelector('.service-count').textContent);
    let sIndex = 0;

    // Add new Service
    function addService() {
        sCounter++;
        sIndex++;
        const serviceDiv = document.createElement('div');
        serviceDiv.classList.add('service');
        serviceDiv.innerHTML = `
        <div class="service bg-light position-relative border px-2 pb-2 pt-5 mt-2">
            <h5 class="service-number border-bottom position-absolute top-0 start-0 m-0 p-1">
                #<span class="service-count">${sCounter}</span>
            </h5>
            <div class="border-bottom position-absolute top-0 end-0" style="color: #dc3545; padding: 4px; cursor: pointer;">
                <i class="deleteService fas fa-trash-alt"></i>
            </div>
            <div class="row gy-2 gx-3 align-items-center">
                <div class="col-sm-4">
                    <label for="serviceName${sIndex}" class="form-label fw-bold">Service Name</label>
                    <input type="text" class="form-control form-control-sm" id="serviceName${sIndex}" name="services[${sIndex}][serviceName]" value="">
                </div>
                <div class="col-sm-5">
                    <label for="serviceDescription${sIndex}" class="form-label fw-bold">Service Description</label>
                    <textarea class="form-control form-control-sm" rows="1" id="serviceDescription${sIndex}" name="services[${sIndex}][serviceDescription]"></textarea>
                </div>
                <div class="col-sm-3">
                    <label for="servicePrice${sIndex}" class="form-label fw-bold">Service Price</label>
                    <input type="number" step="0.00" class="service-price form-control form-control-sm" id="servicePrice${sIndex}" name="services[${sIndex}][servicePrice]">
                </div>
            </div>
        </div>
        `;
        services.appendChild(serviceDiv);
        serviceDiv.scrollIntoView(false);

        calculateTotal();
        updateTotal();
    }

    // Delete Service
    document.addEventListener('DOMContentLoaded', function() {
        services.addEventListener('click', function(e) {
            if (e.target.classList.contains('deleteService')) {
                e.target.closest('.service').remove();
                calculateTotal();
                updateTotal();
            }
        });
    });

    // Calculate Total Price
    function calculateTotal() {
        let total = 0;
        document.querySelectorAll(".service-price").forEach(function(input) {
            let value = parseFloat(input.value);

            if (isNaN(value) || value.length === 0) {
                // console.log("Invalid value, setting to 0");
                value = 0;
            }
            total += value;
        });
        document.getElementById('invoiceTotalPrice').value = total.toFixed(2);
    }

    // Update Total Price
    function updateTotal() {
        document.querySelectorAll(".service-price").forEach(function(input) {
            input.addEventListener("input", function() {
                calculateTotal();
            });
        });
    }

    // Select or Add new Company
    document.addEventListener('DOMContentLoaded', function() {
        const addCompanyBtn = document.getElementById('add-company-btn');
        const newCompanyGroup = document.getElementById('new-company-group');
        const companySelect = document.getElementById('companyID');
        const companyTypeInput = document.getElementById('company-type');

        // Add new Company
        addCompanyBtn.addEventListener('click', function() {
            newCompanyGroup.style.display = newCompanyGroup.style.display === 'none' ? 'block' : 'none';
            companySelect.selectedIndex = 0; // reset the select input
            companyTypeInput.value = 'new'; // set the company type to 'new'
        });
        // Select Company
        companySelect.addEventListener('change', function() {
            newCompanyGroup.style.display = 'none';
            companyTypeInput.value = 'existing'; // set the company type to 'existing'
        });
    });

    // Invoke functions
    calculateTotal();
    updateTotal();
</script>