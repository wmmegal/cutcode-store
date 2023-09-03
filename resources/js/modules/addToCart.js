export default () => ({
    count: 1,
    options: [],
    getOptions() {
        const selects = document.querySelectorAll('[name^=options]');
        this.options = [];

        selects.forEach(select => {
            this.options.push(select.value);
        })
    },
})
