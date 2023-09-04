export default () => ({
    productId: null,
    count: 1,
    options: [],
    inCart: false,
    getOptions() {
        const selects = document.querySelectorAll('[name^=options]');
        this.options = [];

        selects?.forEach(select => {
            this.options.push(select.value);
        })

        return this.options;
    },
    checkInCart() {
        this.getOptions()
        this.$dispatch('checkProductInCart', {productId: this.productId, options: this.options})
    },
})
