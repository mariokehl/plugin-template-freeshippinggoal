/**
 * Main function to handle free shipping goal
 * 
 * @param {number|null} itemSum 
 */
function FreeShippingGoal(itemSum) {
    this.itemSum = itemSum;
    this.getConfig = function () {
        const json = JSON.parse(document.getElementById('free-shipping-config').textContent);
        return json;
    },
    this.getGrossValue = function () {
        const config = this.getConfig();
        return config.grossValue;
    },
    this.getItemSum = function () {
        if (typeof this.itemSum === 'number') return this.itemSum;
        const config = this.getConfig();
        return config.initialData.amount;
    },
    this.getGoalReachedMessage = function () {
        const config = this.getConfig();
        return config.icons.goal + '&nbsp;' + config.messages.goal;
    },
    this.getMissingMessage = function (amount) {
        const config = this.getConfig();
        let msg = config.messages.missing;
        msg = msg.replace(':amount', Intl.NumberFormat('de-DE', { maximumFractionDigits: 2, minimumFractionDigits: 2 }).format(amount));
        msg = msg.replace(':currency', config.currency);
        return msg;
    },
    this.calc = function () {
        let output;

        const amount = (this.getGrossValue() - this.getItemSum());
        if (amount <= 0) {
            output = this.getGoalReachedMessage();
        } else {
            output = this.getMissingMessage(amount);
        }

        let pr = (this.getItemSum() / this.getGrossValue()) * 100;
        pr = Math.floor(pr);
        pr = (pr > 100) ? 100 : pr;

        const progress = document.querySelectorAll('[role="progressbar"]')[0];
        progress.setAttribute('aria-valuenow', pr);
        progress.style['width'] = pr + '%';

        return output;
    },
    this.setLabel = function () {
        const els = document.getElementsByClassName('free-shipping-missing-amount');
        if (!els.length) {
            return;
        } else {
            const self = this;
            Array.prototype.forEach.call(els, function (el) {
                el.innerHTML = self.calc();
            });
        }
    }
}

// Initial setup in checkout view
window.addEventListener('load', () => {
    const goodie = new FreeShippingGoal(null);
    goodie.setLabel();
}, false);

// Shopping cart preview is opened for the first time
waitForElement('.basket-preview').then(() => {
    const goodie = new FreeShippingGoal(null);
    goodie.setLabel();
});

// A new item has been added to the shopping cart
document.addEventListener('afterBasketItemAdded', (e) => {
    const textualAmount = document.querySelector('.toggle-basket-preview .badge').textContent; // e.g. 44,99 EUR
    const itemSum = toFloat(textualAmount);
    const goodie = new FreeShippingGoal(itemSum);
    goodie.setLabel();
}, false);

// When the shopping cart is updated (gets only triggered for existing basket)
document.addEventListener('afterBasketChanged', (e) => {
    const basket = e.detail;
    const itemSum = basket.itemSum + (basket.couponCampaignType === 'promotion' ? basket.couponDiscount : 0);
    const goodie = new FreeShippingGoal(itemSum);
    goodie.setLabel();
}, false);


/**
 * Helper function to wait until an element exists
 * 
 * @param {string} selector 
 */
function waitForElement(selector) {
    return new Promise((resolve) => {
      if (document.querySelector(selector)) {
        return resolve(document.querySelector(selector));
      }
  
      const observer = new MutationObserver((mutations) => {
        if (document.querySelector(selector)) {
          resolve(document.querySelector(selector));
          observer.disconnect();
        }
      });
  
      observer.observe(document.body, {
        childList: true,
        subtree: true
      });
    });
}
  
/**
 * Convert a currency string to a double
 * 
 * @param {string} num
 * @returns {number}
 */
function toFloat(num) {
    let dotPos = num.indexOf('.');
    if (dotPos < 0) dotPos = 0;

    let commaPos = num.indexOf(',');
    if (commaPos < 0) commaPos = 0;

    let sep;
    if (dotPos > commaPos && dotPos) sep = dotPos;
    else {
        if (commaPos > dotPos && commaPos) sep = commaPos;
        else sep = false;
    }

    if (sep == false) return parseFloat(num.replace(/[^\d]/g, ''));

    return parseFloat(num.substr(0, sep).replace(/[^\d]/g, '') + '.' + num.substr(sep + 1, num.length).replace(/[^0-9]/, ''));
}