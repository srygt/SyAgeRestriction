import Plugin from 'src/plugin-system/plugin.class';
import DomAccess from 'src/helper/dom-access.helper';

export default class AgeRestrictionPlugin extends Plugin {

    init() {
        this.minAge = parseInt(DomAccess.getAttribute(this.el, 'data-min-age'), 10);
        this.maxYear = parseInt(DomAccess.getAttribute(this.el, 'data-max-year'), 10);
        
        this.registerForm = DomAccess.closest(this.el, 'form', true);
        
        this.dayField = document.getElementById('registerBirthdayDay');
        this.monthField = document.getElementById('registerBirthdayMonth');
        this.yearField = document.getElementById('registerBirthdayYear');

        if (!this.dayField || !this.monthField || !this.yearField) {
             return;
        }

        this.alertContainer = this._createAlertContainer();
        this.registerForm.prepend(this.alertContainer);
        
        this._limitYearSelection();
        this._addEventListeners();
        this._checkAge(); 
    }

    _createAlertContainer() {
        const div = document.createElement('div');
        div.classList.add('alert', 'alert-danger', 'mt-3', 'sy-age-alert');
        div.style.display = 'none';
        
        const minAgeText = this.minAge.toString();
        const snippet = this.el.dataset.tooYoungError;
        
        // Snippet translationını kullanmaya çalış, yoksa İngilizce varsayılan kullan
        div.innerHTML = snippet ? snippet.replace('{{ minAge }}', minAgeText) : `Due to legal restrictions, you must be at least ${minAgeText} years old to register.`;

        return div;
    }
    
    _limitYearSelection() {
        Array.from(this.yearField.options).forEach(option => {
            const year = parseInt(option.value, 10);
            if (year > this.maxYear) {
                option.style.display = 'none';
                if (option.selected) {
                    this.yearField.value = ''; 
                }
            }
        });
    }

    _addEventListeners() {
        this.dayField.addEventListener('change', this._checkAge.bind(this));
        this.monthField.addEventListener('change', this._checkAge.bind(this));
        this.yearField.addEventListener('change', this._checkAge.bind(this));
    }

    _checkAge() {
        const day = parseInt(this.dayField.value, 10);
        const month = parseInt(this.monthField.value, 10);
        const year = parseInt(this.yearField.value, 10);

        if (!day || !month || !year) {
            this._enableForm();
            return;
        }

        const selectedDate = new Date(year, month - 1, day); 
        const minDate = new Date();
        minDate.setFullYear(minDate.getFullYear() - this.minAge);
        
        if (selectedDate > minDate) {
            this._disableForm();
            this.alertContainer.style.display = 'block';
        } else {
            this._enableForm();
            this.alertContainer.style.display = 'none';
        }
    }

    _disableForm() {
        Array.from(this.registerForm.elements).forEach(element => {
            if (element !== this.dayField && element !== this.monthField && element !== this.yearField) {
                element.disabled = true;
            }
        });
        Array.from(this.registerForm.querySelectorAll('button[type="submit"]')).forEach(button => {
             button.disabled = true;
        });
    }

    _enableForm() {
        Array.from(this.registerForm.elements).forEach(element => {
            element.disabled = false;
        });
    }
}