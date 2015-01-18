/**
 * Created by vigo5190 on 08/01/15.
 */



function FideosTable() {
    this.table = [[], [], [], [], []];
}

FideosTable.prototype.init = function () {

};

FideosTable.prototype.addCell = function (x, y, letter) {
    var self = this;

    self.table[x][y] = {letter: letter};
};

function FideosGame() {
    this.game = $("#gametable");
    //this.table = {};
    this.table = new FideosTable();
    this.status = 'user_empty'; //user_empty, user_wait, user_filled, user_checked, user_send, user_ok
    this.word = [];

}

FideosGame.prototype.init = function () {
    var self = this;

    self.renderTable(self.loadTable());
    self.makeTableListen().makeButtonListen();
    self.updateButtonStatus();
};


FideosGame.prototype.makeTableListen = function () {
    var self = this;

    $('.gametable-td-cell').each(function (idx, el) {
            $(el).bind("click", {el: el, context: self}, self.cellClick);
            $('.gametable-input > input', el).bind("keyup", {el: el, context: self}, self.keyUp);
        }
    );

    return self;
};

FideosGame.prototype.makeButtonListen = function () {
    var self = this;

    $('#game-check-button').bind('click', {context: self}, self.checkButtonClick);

    $('#header-container-right-reload').bind('click', {context: self}, self.reloadButtonClick);


    return self;
};

FideosGame.prototype.reloadButtonClick = function (e) {
    var self = e.data.context;
    $.ajax({
        dataType: "json",
        type: 'POST',
        url: '/game/api/user/clear/',
        context: this,
        async: false,
        headers: {
            'X-Csrf-Token': fideostoken
        },
        success: function (data) {
            if (data.data) {
                $.each(data.data, function (index, value) {
                    $.each(value, function (x, cell) {
                        if (cell.letter) {
                            self.table.addCell(index, x, cell.letter);
                        } else {
                            self.table.addCell(index, x, null);
                        }
                    });
                });
            }
            self.renderTable(self.table);


        }
    });
};

FideosGame.prototype.checkButtonClick = function (e) {
    var self = e.data.context;

    word = self.word;
    table = self.table.table;


    $.ajax({
        dataType: "json",
        type: 'POST',
        url: '/game/api/user/check/word/',
        data: {word: word, table: table},
        context: this,
        async: false,
        headers: {
            'X-Csrf-Token': fideostoken
        },
        success: function (data) {
            if (data.data) {
                $.each(data.data, function (index, value) {
                    $.each(value, function (x, cell) {
                        if (cell.letter) {
                            self.table.addCell(index, x, cell.letter);
                        } else {
                            self.table.addCell(index, x, null);
                        }
                    });
                });
            }
            self.renderTable(self.table);


        }
        //error: handleFailedAjax
    });


};

FideosGame.prototype.setStatus = function (status) {
    var self = this;
    self.status = status;

    self.updateButtonStatus(self.status);
};

FideosGame.prototype.isAddedLetterInWord = function () {
    var self = this;
    self.isaliw = false;
    $.each(self.word, function (index, letter) {
        if (letter.status == 'pressed') {
            self.isaliw = true;
        }
    });

    return self.isaliw;

};

FideosGame.prototype.updateButtonStatus = function () {
    var self = this;
    var status = self.status;

    if (status == 'user_empty') {
        $('#game-check-button').html('Выберите ячейку');
        $('#game-check-button').attr('disabled', 'disabled');
    } else if (status == 'user_wait') {
        $('#game-check-button').html('Вставьте букву');
        $('#game-check-button').attr('disabled', 'disabled');
    } else if (status == 'user_filled') {
        $('#game-check-button').html('Выделите слово');
        $('#game-check-button').attr('disabled', 'disabled');
    } else if (status == 'user_checked') {
        //console.log('is'+self.isAddedLetterInWord());
        //if (self.isAddedLetterInWord())
        if ((self.word.length >= 3) && (self.isAddedLetterInWord())) {
            $('#game-check-button').html('Отправить слово');
            $('#game-check-button').removeAttr('disabled');
        } else {
            $('#game-check-button').html('Выделите слово');
            $('#game-check-button').attr('disabled', 'disabled');
        }
    }
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
        if ((self.status == 'user_filled') || (self.status == 'user_checked')) {


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

    var re = /gametable-cell-(\d)-(\d)/i;
    var found = id.match(re);
    var x = parseInt(found[1], 10); //row
    var y = parseInt(found[2], 10); //cell

    var letter = {};


    letter.x = x;
    letter.y = y;
    letter.val = $('.gametable-cell', cell).html();
    if ($(cell).hasClass('gametable-td-cell-filled')) {
        letter.status = 'filled';
    } else if ($(cell).hasClass('gametable-td-cell-pressed')) {
        letter.status = 'pressed';
    }


    if (wordLength > 0) {
        var prevLetter = self.word[self.word.length - 1];

        var lettersInWordWithSameXY = $.grep(self.word, function (n, i) {
            return (n.x == letter.x && n.y == letter.y);
        });

        var lettersInWordCount = lettersInWordWithSameXY.length;

        if (
            (lettersInWordCount == 0) &&
            (prevLetter.x == letter.x) &&
            ( (prevLetter.y == letter.y - 1) || (prevLetter.y == letter.y + 1) )
        ) {
            self.word.push(letter);
            cell.addClass('gametable-td-cell-selected');
            self.setStatus('user_checked');
            //console.log('xxx');
        } else if (
            (lettersInWordCount == 0) &&
            (prevLetter.y == letter.y) &&
            ( (prevLetter.x == letter.x - 1) || (prevLetter.x == letter.x + 1) )
        ) {
            self.word.push(letter);
            cell.addClass('gametable-td-cell-selected');
            self.setStatus('user_checked');
            //console.log('yyy');
        } else if ((prevLetter.y == letter.y) && (prevLetter.x == letter.x)) {
            self.word.pop();
            cell.removeClass('gametable-td-cell-selected');
            self.setStatus('user_checked');
            //console.log('rem');
        }


    } else {
        self.word.push(letter);
        cell.addClass('gametable-td-cell-selected');
        self.setStatus('user_checked');
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
        headers: {
            'X-Csrf-Token': fideostoken
        },
        success: function (data) {
            if (data.data) {
                $.each(data.data, function (index, value) {
                    $.each(value, function (x, cell) {
                        if (cell.letter) {
                            self.table.addCell(index, x, cell.letter);
                        } else {
                            self.table.addCell(index, x, null);
                        }
                    });
                });
            }
        }
        //error: handleFailedajax
    });

    return self.table;

};

FideosGame.prototype.renderTable = function (data) {
    var self = this;
    //$.each(this.table, function (index, value) {
    //    $.each(value, function (x, cell) {
    //        if (cell) {
    //            $('#gametable-cell-' + index + '-' + x + ' > .gametable-cell').html(cell);
    //            $('#gametable-cell-' + index + '-' + x).addClass('gametable-td-cell-filled');
    //        } else {
    //            $('#gametable-cell-' + index + '-' + x).addClass('gametable-td-cell-empty');
    //        }
    //    });
    //});

    if (!data) {
        data = self.table;
    }

    $.each(data.table, function (index, value) {
        $.each(value, function (x, cell) {
            $('#gametable-cell-' + index + '-' + x).removeClass('gametable-td-cell-filled');
            $('#gametable-cell-' + index + '-' + x).removeClass('gametable-td-cell-empty');
            $('#gametable-cell-' + index + '-' + x).removeClass('gametable-td-cell-wait');
            $('#gametable-cell-' + index + '-' + x).removeClass('gametable-td-cell-pressed');
            $('#gametable-cell-' + index + '-' + x).removeClass('gametable-td-cell-selected');
            if (cell.letter != null) {
                $('#gametable-cell-' + index + '-' + x + ' > .gametable-cell').html(cell.letter);
                $('#gametable-cell-' + index + '-' + x).addClass('gametable-td-cell-filled');
            } else {
                $('#gametable-cell-' + index + '-' + x).addClass('gametable-td-cell-empty');
                $('#gametable-cell-' + index + '-' + x + ' > .gametable-cell').html('');
            }

        });
    });
    return self;
};


$(document).ready(function () {
    fideos = new FideosGame();
    fideos.init();
});