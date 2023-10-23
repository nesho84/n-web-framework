'use strict';

console.log("invoices.js loaded...");

// Services
const btnAddService = document.getElementById('btn-add-service');
const services = document.getElementById('services');
let sIndex = 0;
// Company
const btnAddCompany = document.getElementById('btn-add-company');
const newCompanyGroup = document.getElementById('new-company-group');
const companySelect = document.getElementById('companyID');
const companyTypeInput = document.getElementById('company-type');

document.addEventListener('DOMContentLoaded', function () {
    // sweetalert2 Confirm Delete Dialog
    document.querySelectorAll(".btn-delete").forEach((link) => {
        link.addEventListener("click", confirmDeleteDialog);
    });

    // Add new Company
    if (btnAddCompany) btnAddCompany.addEventListener('click', addCompany);
    // Select Company
    if (companySelect) companySelect.addEventListener('change', selectCompany);

    // Add new Service
    if (btnAddService) btnAddService.addEventListener('click', addService);
    // Delete Service
    if (services) services.addEventListener('click', deleteService);

    // Set/Refresh Total Price
    setTotalPrice();

    // Attach the submit event handler to the form (ajax.js)
    const form = document.querySelector("#formInvoices");
    if (form) {
        form.addEventListener("submit", async (event) => {
            await handleFormSubmit(event);
        });
    }

    // Select with search option (dselect library)
    const selectBox = document.getElementById("companyID");
    if (selectBox) {
        dselect(selectBox, {
            search: true, // Toggle search feature. Default: false
            creatable: false, // Creatable selection. Default: false
            clearable: false, // Clearable selection. Default: false
            maxHeight: '360px', // Max height for showing scrollbar. Default: 360px
            size: 'sm', // Can be "sm" or "lg". Default ''
        });
    }
});

//------------------------------------------------------------
function addCompany()
//------------------------------------------------------------
{
    newCompanyGroup.style.display = newCompanyGroup.style.display === 'none' ? 'block' : 'none';
    companySelect.selectedIndex = 0; // reset the select input
    if (companyTypeInput.value === 'existing') {
        companyTypeInput.value = 'new'; // set the company type to 'new'
    } else {
        companyTypeInput.value = 'existing';
    }
}

//------------------------------------------------------------
function selectCompany()
//------------------------------------------------------------
{
    newCompanyGroup.style.display = 'none';
    companyTypeInput.value = 'existing'; // set the company type to 'existing'
}

//------------------------------------------------------------
function addService()
//------------------------------------------------------------
{
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

//------------------------------------------------------------
function deleteService(event)
//------------------------------------------------------------
{
    if (event.target.classList.contains('deleteService')) {
        event.target.closest('.service').remove();
        // Update Service Counter
        updateServiceCounter();
        // Set/Refresh Total Price
        setTotalPrice();
    }
}

//------------------------------------------------------------
function updateServiceCounter()
//------------------------------------------------------------
{
    // Update # counter
    const serviceCount = document.querySelectorAll('.service-count');
    serviceCount.forEach(function (item, index) {
        if (item !== null) {
            item.textContent = index + 1;
        }
    });
}

//------------------------------------------------------------
function calculateTotalPrice()
//------------------------------------------------------------
{
    let totalInput = document.getElementById('invoiceTotalPrice');
    let total = 0;
    document.querySelectorAll(".service").forEach(function (row) {
        let quantityInput = row.querySelector(".service-quantity");
        let quantity = parseFloat(row.querySelector(".service-quantity").value);
        let priceInput = row.querySelector(".service-price");
        let price = parseFloat(priceInput.value);
        if (isNaN(quantity) || quantity < 1) {
            quantity = 1;
            quantityInput.value = 1;
        }
        if (isNaN(price) || price.length === 0) {
            price = 0;
        }
        priceInput.value = price.toFixed(2);
        total += quantity * price;
    });
    if (totalInput) {
        totalInput.value = total.toFixed(2);
    }
}

//------------------------------------------------------------
function setTotalPrice()
//------------------------------------------------------------
{
    calculateTotalPrice();
    document.querySelectorAll(".service").forEach(function (input) {
        input.addEventListener("input", function () {
            // Calculate also on input event
            calculateTotalPrice();
        });
    });
}