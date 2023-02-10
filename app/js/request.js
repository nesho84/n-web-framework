
// // This is example how it should be called in the view
// const form = document.getElementById('form');
// const resultContainer = document.getElementById('result');
// const messageContainer = document.getElementById('message');
// const spinnerContainer = document.getElementById('spinner');

// form.addEventListener('submit', createCrudHandler(form, resultContainer, messageContainer, spinnerContainer));

function ajaxRequest(operation, formElement, resultContainer, messageContainer, spinnerContainer) {
    return async (event) => {
        event.preventDefault();

        const formData = new FormData(formElement);
        const url = formElement.action;

        let result;
        try {
            // spinnerContainer.classList.remove('hidden');
            switch (operation) {
                case 'insert':
                    for (var x of formData) console.log(x);
                    result = await insertData(formData, url);
                    break;
                case 'update':
                    result = await updateData(formData, url);
                    break;
                case 'delete':
                    result = await deleteData(formData.get('id'));
                    break;
                case 'read':
                    result = await readData(url);
                    break;
                default:
                    throw new Error('Invalid operation');
            }

            result = await result.json();
            if (result.status === 'success') {
                if (result.error) {
                    throw new Error(result.error);
                } else {
                    // messageContainer.innerHTML = 'Operation successful';
                    // messageContainer.classList.add('success');
                    // messageContainer.classList.remove('error');
                }
            } else {
                throw new Error(result.message);
            }
        } catch (error) {
            // messageContainer.innerHTML = error.message;
            // messageContainer.classList.add('error');
            // messageContainer.classList.remove('success');
        } finally {
            // spinnerContainer.classList.add('hidden');
        }

        resultContainer.innerHTML = JSON.stringify(result, null, 2);
    };
}

async function insertData(data, url) {
    try {
        const response = await fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(data)
        });
        const result = await response.json();
        return result;
    } catch (error) {
        console.error('Error inserting data: ', error);
        return { error: error.message };
    }
}

async function deleteData(id) {
    try {
        const response = await fetch(`/api/delete.php?id=${id}`, {
            method: 'DELETE'
        });
        const result = await response.json();
        return result;
    } catch (error) {
        console.error(`Error deleting data with id ${id}: `, error);
        return { error: error.message };
    }
}

async function updateData(data, url) {
    try {
        const response = await fetch(url, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(data)
        });
        const result = await response.json();
        return result;
    } catch (error) {
        console.error('Error updating data: ', error);
        return { error: error.message };
    }
}

async function readData(url) {
    try {
        const response = await fetch('/api/read.php');
        const result = await response.json();
        return result;
    } catch (error) {
        console.error('Error reading data: ', error);
        return { error: error.message };
    }
}