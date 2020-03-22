class FormValidate {
    constructor(form) {
        this.form = form;

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

    errorMessage(field, valid) {
        let message = '';

        if(field.value === '') {
            message = 'Pole jest wymagane.';
        } else {
            message = field.dataset.invalidMessage;
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
            const elements = this.getFields();

            for (const el of elements) {
                const valid = this.fieldValidator(el);

                if(!valid) {
                    e.preventDefault();
                }

                this.errorMessage(el, valid);
            }
        });
    }

    emailValidation(value) {
        return /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/.test(value);
    }

    ageValidation(value) {
        return value > 17 && value < 100 && /^-?\d+$/.test(value);
    }
};