$(function() {

    var hideErrContainers = function () {
        $('.alert-danger').addClass('hidden');
        $('.alert-danger').text('');
    };

    var showErrorContainer = function ($container, $msg) {
        $container.text($msg);
        $container.removeClass('hidden');
    };

    $(".invest-btn").click(function () {
        // define jQuery objects
        var $amountInput = $(this).closest('td').find('.invest-amount-input');
        var $availableForInvestment = $(this).closest('tr').find('.available-for-investment');
        var $errContainer = $(this).closest('tr').find('.alert-danger');
        var $moneyContainer = $('#moneyAvailable');

        // define variables
        var loanId = $(this).closest('td').data('id');
        var investAmount = $amountInput.val();

        $.ajax({
            url: 'http://localhost/mintos/web/app_dev.php/invest',
            data: {"loan_id": loanId, "invest_amount": investAmount},
            type: 'post',
            success: function(result)
            {
                // if true response, update available for investment and clear err messages
                if (result.status) {
                    $availableForInvestment.text('$' + result.availableForInvestments);
                    $moneyContainer.text(result.moneyAvailable);
                    hideErrContainers();
                    return;
                }
                // if false response,show error message
                showErrorContainer($errContainer, result.message);
            }
        });
    });
});

