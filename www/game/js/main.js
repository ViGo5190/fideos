/**
 * Created by vigo5190 on 08/01/15.
 */


function FideosGame() {
    this.game = $("#gametable");
    this.table = {};
}

FideosGame.prototype.init = function () {
    var self = this;

    self.loadTable().renderTable().makeTableListen();
};


FideosGame.prototype.makeTableListen = function () {
    var self = this;

    $('.gametable-td-cell').each(function (idx, el) {
            $(el).bind("click", {el: el}, self.cellClick);
            $('.gametable-input > input', el).bind("keyup", {el: el}, self.keyUp);
        }
    );


};


FideosGame.prototype.keyUp = function (e) {
    var data = e.data;
    var el = $(data.el);

    if ($(el).hasClass('gametable-td-cell-wait')) {

        $('.gametable-cell', el).html(this.value);

        $('.gametable-cell', el).removeClass('hidden');
        $('.gametable-input', el).addClass('hidden');
        $(el).removeClass('gametable-td-cell-wait').addClass('gametable-td-cell-pressed')
    }

};

FideosGame.prototype.cellClick = function (e) {
    var data = e.data;
    var el = $(data.el);

    if (el.hasClass('gametable-td-cell-empty')) {
        console.log('click:' + el.attr('id'));

        $('.gametable-cell', '.gametable-td-cell-pressed').html('');
        $('.gametable-input > input', '.gametable-td-cell-pressed').val('');
        $('.gametable-td-cell-pressed').removeClass('gametable-td-cell-pressed').addClass('gametable-td-cell-empty');

        $('.gametable-cell', '.gametable-td-cell-wait').html('');
        $('.gametable-input > input', '.gametable-td-cell-wait').val('');
        $('.gametable-td-cell-wait').removeClass('gametable-td-cell-wait').addClass('gametable-td-cell-empty');


        $('.gametable-cell', el).addClass('hidden');
        $('.gametable-input', el).removeClass('hidden').focus();
        $('.gametable-input > input', el).focus();
        el.removeClass('gametable-td-cell-empty').addClass('gametable-td-cell-wait')


    }


};

FideosGame.prototype.loadTable = function () {
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
                //console.log(data);

                //this.orderList.init(data.data);
                //self.renderOrders();
            }
        }
        //error: handleFailedAjax
    });

    return self;

};

FideosGame.prototype.renderTable = function () {
    var self = this;
    $.each(this.table, function (index, value) {
        $.each(value, function (x, cell) {
            if (cell) {
                $('#gametable-cell-' + index + '-' + x + ' > .gametable-cell').html(cell);
                $('#gametable-cell-' + index + '-' + x).addClass('gametable-td-cell-filled');
            } else {
                $('#gametable-cell-' + index + '-' + x).addClass('gametable-td-cell-empty');
            }
        });
    });
    return self;
};


$(document).ready(function () {
    fideos = new FideosGame();
    fideos.init();
});