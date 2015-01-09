/**
 * Created by vigo5190 on 08/01/15.
 */


function FideosGame() {
    this.game = $("#gametable");
    this.table = {};
    this.status = 'user_empty'; //user_empty, user_wait, user_filled, user_checked, user_send, user_ok
    this.word = [];
}

FideosGame.prototype.init = function () {
    var self = this;

    self.loadTable().renderTable().makeTableListen();
};


FideosGame.prototype.makeTableListen = function () {
    var self = this;

    $('.gametable-td-cell').each(function (idx, el) {
            $(el).bind("click", {el: el, context: self}, self.cellClick);
            $('.gametable-input > input', el).bind("keyup", {el: el, context: self}, self.keyUp);
        }
    );


};


FideosGame.prototype.setStatus = function (status) {
    var self = this;
    self.status = status;
};

FideosGame.prototype.keyUp = function (e) {
    var data = e.data;
    var el = $(data.el);
    var self = data.context;

    if ($(el).hasClass('gametable-td-cell-wait')) {

        $('.gametable-cell', el).html(this.value);

        $('.gametable-cell', el).removeClass('hidden');
        $('.gametable-input', el).addClass('hidden');
        $(el).removeClass('gametable-td-cell-wait').addClass('gametable-td-cell-pressed')
        self.setStatus('user_filled');

    }

};


FideosGame.prototype.cellClick = function (e) {
    var data = e.data;
    var el = $(data.el);
    var self = data.context;

    if (el.hasClass('gametable-td-cell-empty')) {
        console.log('click:' + el.attr('id'));


        $('.gametable-td-cell').removeClass('gametable-td-cell-selected');
        self.word = [];

        $('.gametable-cell', '.gametable-td-cell-pressed').html('');
        $('.gametable-input > input', '.gametable-td-cell-pressed').val('');
        $('.gametable-td-cell-pressed').removeClass('gametable-td-cell-pressed').addClass('gametable-td-cell-empty');

        $('.gametable-cell', '.gametable-td-cell-wait').html('');
        $('.gametable-input > input', '.gametable-td-cell-wait').val('');
        $('.gametable-td-cell-wait').removeClass('gametable-td-cell-wait').addClass('gametable-td-cell-empty');


        $('.gametable-cell', el).addClass('hidden');
        $('.gametable-input', el).removeClass('hidden').focus();
        $('.gametable-input > input', el).focus();
        el.removeClass('gametable-td-cell-empty').addClass('gametable-td-cell-wait');


        self.setStatus('user_wait');

    } else if ((el.hasClass('gametable-td-cell-filled')) || (el.hasClass('gametable-td-cell-pressed'))) {
        if (self.status == 'user_filled') {
            //console.log('select: ' + el.attr('id'));


            self.addCellToWord(el, self);

        } else if (self.status == 'user_wait') {
            self.setStatus('user_empty');
        }
    }


};


FideosGame.prototype.addCellToWord = function (cell, context) {
    var self = context;

    var wordLength = self.word.length;


    var id = cell.attr('id');


    re = /gametable-cell-(\d)-(\d)/i;
    found = id.match(re);
    var x = parseInt(found[1], 10); //row
    var y = parseInt(found[2], 10); //cell

    var letter = {};


    letter.x = x;
    letter.y = y;
    letter.val = $('.gametable-cell', cell).html();

    console.log(x);
    console.log(y);


    if (wordLength > 0) {
        var prevLetter = self.word[self.word.length - 1];


        if ((prevLetter.x == letter.x) && ( (prevLetter.y == letter.y - 1) || (prevLetter.y == letter.y + 1) )) {
            self.word.push(letter);
            cell.addClass('gametable-td-cell-selected');
            console.log('xxx');
        } else if ((prevLetter.y == letter.y) && ( (prevLetter.x == letter.x - 1) || (prevLetter.x == letter.x + 1) )) {
            self.word.push(letter);
            cell.addClass('gametable-td-cell-selected');
            console.log('yyy');
        }


    } else {
        self.word.push(letter);
        cell.addClass('gametable-td-cell-selected');
    }


    console.log(self.word);

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