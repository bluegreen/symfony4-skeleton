class FormValidate {
    constructor(form) {
        this.form = form;
        this.emailElement = this.form.querySelector('#person_email');
        this.form.setAttribute("novalidate", "novalidate");

        this.prepareElements();
        this.bindSubmit();
    }

    getFields() {
        return [...this.form.querySelectorAll("input:not(:disabled), select:not(:disabled), textarea:not(:disabled)")];
    }

    prepareElements() {
        const elements = this.getFields();

        for (const el of elements) {
            const tag = el.tagName.toLowerCase();
            const type = el.type.toLowerCase();
            let eventName = "input";

            if (type === "checkbox" || type === "radio" || tag === "select") {
                eventName = "change";
            }

            el.addEventListener(eventName, e => this.testInput(e.target));
        }
    }

    testInput(input) {
        let valid = this.fieldValidator(input);
        this.errorMessage(input, valid);

        return valid;
    }

    fieldValidator(input) {
        let valid = false;

        if(input.required === true && input.value === '') {
            return valid;
        }

        switch (input.id) {
            case 'person_email':
                valid = this.emailValidation(input.value);
                break;
            case 'person_age':
                valid = this.ageValidation(input.value);
                break;
            case 'person_dataProcessingAgreement':
                valid = input.checked;
                break;
            default:
                valid = true;
        }

        return valid;
    }

    errorMessage(field, valid, messageOverwrite = '') {
        let message = '';

        if(field.value === '') {
            message = 'Pole jest wymagane.';
        } else {
            message = (messageOverwrite !== '') ? messageOverwrite : field.dataset.invalidMessage;
        }

        let errorMessageContainer = field.closest(".form-row").querySelector(".invalid-message");

        if (!valid) {
            field.closest(".form-row").classList.add("form-error");
            errorMessageContainer.innerHTML = message;
            errorMessageContainer.style.display = 'block';
        } else {
            field.closest(".form-row").classList.remove("form-error");
            errorMessageContainer.innerHTML = '';
            errorMessageContainer.style.display = 'none';
        }
    }

    bindSubmit() {
        this.form.addEventListener('submit', e => {
            e.preventDefault();

            let formErrors = false;
            const elements = this.getFields();

            for (const el of elements) {
                const valid = this.fieldValidator(el);

                if(!valid) {
                    formErrors = true;
                }

                this.errorMessage(el, valid);
            }

            if (!formErrors) {
                const formData = new FormData();
                for (const el of elements) {
                    formData.append(el.name, el.value);
                }

                const url = this.form.getAttribute("action");
                this.getData(
                    url,
                    'POST',
                    formData
                ).then((result) => {
                    if(typeof result.data === 'string' && result.data === 'true') {
                        this.form.reset();
                        document.getElementById("statusSaveData").style.display = 'block';
                        setTimeout(function() {
                            document.getElementById("statusSaveData").style.display = 'none';
                        }, 5000);
                    } else {
                        this.errorMessage(this.emailElement, false, 'Wprowadzony adres e-mail nie istnieje.');
                    }
                });
            }
        });
    }

    emailValidation(value) {
        return /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/.test(value);
    }

    ageValidation(value) {
        return value > 17 && value < 100 && /^-?\d+$/.test(value);
    }

    getData(url, method, formData) {
        return fetch(url, {
            method: method,
            body: formData
        }).then((response) => {
            return response.json();
        });
    }
};