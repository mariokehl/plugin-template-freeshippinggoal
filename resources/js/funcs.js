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
    const goal = new FreeShippingGoal(null);
    goal.setLabel();
}, false);

// New item added to basket
document.addEventListener('afterBasketChanged', (e) => {
    const basket = e.detail;
    const itemSum = basket.itemSum;
    const goal = new FreeShippingGoal(itemSum);
    goal.setLabel();
}, false);