function demoFromHTML() {
    var pdf = new jsPDF()
    source = $('#divListado')[0];

    margins = {
        top: 80,
        bottom: 60,
        left: 40,
        width: 122
    };
    pdf.fromHTML(
            source, // HTML string or DOM elem ref.
            margins.left, // x coord
            margins.top, {// y coord
                'width': margins.width, // max width of content on PDF
            },
    function(dispose) {
        // dispose: object with X, Y of the last line add to the PDF
        //          this allow the insertion of new lines after html
        pdf.save('balance.pdf');
    }
    , margins);
}