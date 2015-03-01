ngs.CreditLoad = Class.create(ngs.AbstractLoad, {
    initialize: function ($super, shortCut, ajaxLoader) {
        $super(shortCut, "main_payment", ajaxLoader);
    },
    getUrl: function () {
        return "credit";
    },
    getMethod: function () {
        return "POST";
    },
    getContainer: function () {
        return "payment_details";
    },
    getName: function () {
        return "payment_credit";
    },
    afterLoad: function () {
        this.calculateCreditMonthlyPayments();
    },
    calculateCreditMonthlyPayments: function () {
        jQuery("#calculate_credit_monthly_payments_button").click(function () {
            var deposit_amd = jQuery("#deposit_amd").val();
            var selected_credit_months = jQuery("#selected_credit_months").val();
            var credit_supplier_id = jQuery("#credit_supplier_id").val();

            ngs.load("payment_credit", {
                do_shipping: 0,
                deposit_amd: deposit_amd,
                selected_credit_months: selected_credit_months,
                credit_supplier_id: credit_supplier_id
            });
        });
    }
});
