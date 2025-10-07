

function weightCalc(num, decimals) {
    // debugger;
    return Math.round(num * Math.pow(10, decimals)) / Math.pow(10, decimals);
}

function PerimeterCalc(length, width) {
    // debugger;
    length = Number(length);
    width = Number(width);
    return Math.round(2 * (length + width));
}
$(function () {

    $('#thickness').change(function () {
        // debugger
        content = $('#thickness').val();
        var thickness = $("#thickness").val();
        var length = $("#length").val();
        var width = $("#width").val();
        var qty = $("#quantity").val();
        var total = (7.85 / 10000) * (thickness * length * width);
        // var total = thickness * length * width;
        total = total * qty;
        total = weightCalc(total, 3);

        $("#weight").val(total + " كجم ");
    });

    function cuttingLength(length, width) {
        length = Number(length);
        width = Number(width);
        return Math.round((length + width) / 2);
    }


    $('#quantity').change(function () {
        content = $('#width').val();
        var thickness = $("#thickness").val();
        var length = $("#length").val();
        var width = $("#width").val();
        var qty = $("#quantity").val();
        var total = (7.85 / 10000) * (thickness * length * width);
        // var total =  thickness * length * width;
        total = total * qty;
        total = weightCalc(total, 3);

        $("#weight").val(total + " كجم ");
    });
    $('#length').change(function () {
        // debugger
        var length = $("#length").val();
        var width = $("#width").val();
        var total = PerimeterCalc(length, width);
        $("#Perimeter").val(total);
        var thickness = $("#thickness").val();
        var length = $("#length").val();
        var width = $("#width").val();
        var qty = $("#quantity").val();
        var total = (7.85 / 10000) * (thickness * length * width);
        // var total =  thickness * length * width;
        total = total * qty;
        total = weightCalc(total, 3);

        $("#weight").val(total + " كجم ");
        $("#cuttinglength").val(cuttingLength(length, width));
    });
    $('#width').change(function () {
        // debugger
        var length = $("#length").val();
        var width = $("#width").val();
        var total = PerimeterCalc(length, width);
        $("#Perimeter").val(total);
        var thickness = $("#thickness").val();
        var length = $("#length").val();
        var width = $("#width").val();
        var qty = $("#quantity").val();
        var total = (7.85 / 10000) * (thickness * length * width);
        // var total =  thickness * length * width;
        total = total * qty;
        total = weightCalc(total, 3);

        $("#weight").val(total + " كجم ");
        $("#cuttinglength").val(cuttingLength(length, width));
    });
});
