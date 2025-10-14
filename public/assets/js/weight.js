function weightCalc(num, decimals) {
    // debugger;
    return Math.round(num * Math.pow(10, decimals)) / Math.pow(10, decimals);
}

function parseThickness(thicknessText) {
    if (!thicknessText) return 0;
    // Extract number from text like "2مم" or "2.5مم"
    var match = thicknessText.match(/(\d+\.?\d*)/);
    return match ? parseFloat(match[1]) : 0;
}

$(function () {
    // debugger;
    var content = $('#thickness').val();
    $('#thickness').change(function () {
        // debugger
        content = $('#thickness').val();
        var thickness = parseThickness($("#thickness").val());
        var length = $("#length").val();
        var width = $("#width").val();
        var qty = $("#quantity").val();

        if (thickness && length && width && qty) {
            var total = (7.85 / 10000) * (thickness * length * width);
            total = total * qty;
            total = weightCalc(total, 3);
            $("#weight").val(total);
        } else {
            $("#weight").val("");
        }
    });

    $('#length').keyup(function () {
        content = $('#length').val();
        var thickness = parseThickness($("#thickness").val());
        var length = $("#length").val();
        var width = $("#width").val();
        var qty = $("#quantity").val();

        if (thickness && length && width && qty) {
            var total = (7.85 / 10000) * (thickness * length * width);
            total = total * qty;
            total = weightCalc(total, 3);
            $("#weight").val(total);
        } else {
            $("#weight").val("");
        }
    });

    $('#width').keyup(function () {
        content = $('#width').val();
        var thickness = parseThickness($("#thickness").val());
        var length = $("#length").val();
        var width = $("#width").val();
        var qty = $("#quantity").val();

        if (thickness && length && width && qty) {
            var total = (7.85 / 10000) * (thickness * length * width);
            total = total * qty;
            total = weightCalc(total, 3);
            $("#weight").val(total);
        } else {
            $("#weight").val("");
        }

        var diameter = $("#width").val() / 3.14;
        diameter = weightCalc(diameter, 3);
        $("#diameter").val(diameter);
    });

    $('#quantity').change(function () {
        content = $('#width').val();
        var thickness = parseThickness($("#thickness").val());
        var length = $("#length").val();
        var width = $("#width").val();
        var qty = $("#quantity").val();

        if (thickness && length && width && qty) {
            var total = (7.85 / 10000) * (thickness * length * width);
            total = total * qty;
            total = weightCalc(total, 3);
            $("#weight").val(total);
        } else {
            $("#weight").val("");
        }
    });
    $('#diameter').keyup(function () {
        // debugger;
        var diameter = $("#diameter").val();
        var width = $("#diameter").val() * 3.14;
        width = weightCalc(width, 3);
        $("#width").val(width);
        content = $('#width').val();
        var thickness = $("#thickness").val();
        var length = $("#length").val();
        var width2 = $("#width").val();
        var qty = $("#quantity").val();
        var total = (7.85 / 10000) * (thickness * length * width2);
        // var total =  thickness * length * width;
        total = total * qty;
        total = weightCalc(total, 3);

        $("#weight").val(total);
    });
    var content = $('#foldThickness').val();
    $('#foldThickness').change(function () {
        // debugger
        content = $('#foldThickness').val();
        var thickness = $("#foldThickness").val();
        var length = $("#foldLength").val() * 100;
        var width = $("#foldWidth").val();
        // var qty = $("#foldQnty").val();
        var total = (7.85 / 10000) * (thickness * length * width);
        // var total = thickness * length * width;
        total = total;
        total = weightCalc(total, 3);

        $("#foldWeight").val(total);
    });

    $('#foldLength').keyup(function () {
        content = $('#foldLength').val();
        var thickness = $("#foldThickness").val();
        var length = $("#foldLength").val() * 100;
        var width = $("#foldWidth").val();
        //  var qty = $("#foldQnty").val();
        var total = (7.85 / 10000) * (thickness * length * width);
        // var total =  thickness * length * width;
        total = total;
        total = weightCalc(total, 3);

        $("#foldWeight").val(total);
    });

    $('#foldWidth').keyup(function () {

        content = $('#foldWidth').val();
        var thickness = $("#foldThickness").val();
        var length = $("#foldLength").val() * 100;
        var width = $("#foldWidth").val();
        // var qty = $("#foldQnty").val();
        var total = (7.85 / 10000) * (thickness * length * width);
        // var total =  thickness * length * width;
        total = total;
        total = weightCalc(total, 3);
        $("#foldWeight").val(total);
        var diameter = $("#foldWidth").val() / 3.14;
        diameter = weightCalc(diameter, 3);
        $("#diameter").val(diameter);
    });


});
