/**
 * Created by vigo5190 on 08/01/15.
 */


function FideosGame() {
    this.game = $("#gametable");
    this.table = {};
}

FideosGame.prototype.init = function () {
    var self = this;

    self.loadTable();
    self.renderTable();
};


FideosGame.prototype.loadTable = function() {
    var self = this;
    $.ajax({
        dataType: "json",
        url: '/game/api/get/table/',
        //data: {action: 'loadOrders'},
        context: this,
        async: false,
        success: function (data) {
            if (data) {
                this.table = data;
                console.log(data);

                //this.orderList.init(data.data);
                //self.renderOrders();
            }
        }
        //error: handleFailedAjax
    });

};

FideosGame.prototype.renderTable = function() {
    var self = this;
    $.each(this.table, function (index, value) {
        $.each(value, function (x, cell) {
            if (cell){
                $('#gametable-cell-'+index+'-'+x).html(cell);
            }
                //console.log(cell);
        });
    });
};



$(document).ready(function () {
    fideos = new FideosGame();
    fideos.init();
});