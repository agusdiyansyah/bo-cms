$(document).ready(function() {
    // var data = {
    //     title: "Coba",
    //     pesan: "Ini pesan",
    //     trueIcon: "fa fa-check",
    //     falseIcon: "fa fa-file-pdf-o",
    //     trueLabel: "OK",
    //     falseLabel: "NO",
    //     trueClick: function () { alert("OK") },
    //     falseClick: "",
    // };
    //
    // confirm(data);

});

function confirm (data) {
    if ($("body > div").hasClass("confirm-wrapper")) {
        $(".confirm-wrapper").remove();
    }
    var html = "";
    html +='    <div class="confirm-wrapper text-right">';
    html +='		<div class="confirm bg-gray text-right">';
    html +='			<div class="row">';
    html +='				<div class="col-sm-10 col-sm-push-2">';
    html +='					<h3 class="title">Hapus Riwayat Cuti</h3>';
    html +='					<p class="pesan">';
    html +='						Lorem ipsum dolor sit amet, consectetur adipisicing elit.';
    html +='					</p>';
    html +='					<div class="btn-group">';
    html +='						<button type="button" class="aksi-dismis btn btn-default"><i class=""></i>&nbsp <span></span></button>';
    html +='						<button type="button" class="aksi-confirm btn btn-primary"><i class=""></i>&nbsp <span></span></button>';
    html +='					</div>';
    html +='				</div>';
    html +='			</div>';
    html +='			<div class="overlay">';
    html +='				<i class=""></i>';
    html +='			</div>';
    html +='		</div>';
    html +='	</div>';

    $("body").prepend(html);

    var title = $('.confirm-wrapper .confirm .title');
    var pesan = $('.confirm-wrapper .confirm .pesan');
    var overlay = $('.confirm-wrapper .confirm .overlay');
    var ok = $('.confirm-wrapper .confirm .aksi-confirm');
    var no = $('.confirm-wrapper .confirm .aksi-dismis');

    $('.confirm-wrapper').addClass("active");

    // title
    if (data.title == null) {
        title.hide();
    } else {
        title.html(data.title);
    }

    // pesan
    if (data.pesan == null) {
        pesan.hide();
    } else {
        pesan.html(data.pesan);
    }

    // falseIcon
    if (data.falseIcon == null) {
        no.find("i").addClass("fa fa-times");
    } else {
        no.find("i").addClass(data.falseIcon);
    }

    // falseLabel
    if (data.falseLabel == null) {
        no.find("span").html("Batalkan");
    } else {
        no.find("span").html(data.falseLabel);
    }

    // falseClick
    if (data.falseClick == null || data.falseClick == "") {
        no.click(function (e) {
            e.preventDefault();
            $('.confirm-wrapper').removeClass("active");
            $(".confirm-wrapper").remove();
        });
    } else {
        no.click(data.falseClick);
    }

    // trueIcon
    if (data.trueIcon == null) {
        ok.find("i").hide();
        overlay.find("i").hide();
    } else {
        ok.find("i").addClass(data.trueIcon);
        overlay.find("i").addClass(data.trueIcon);
    }

    // trueLabel
    if (data.trueLabel != null) {
        ok.find("span").html(data.trueLabel);
    }

    if (data.trueLabel == null && data.trueIcon == null) {
        ok.hide();
    }

    // trueClick
    if (data.trueClick != null) {
        ok.click(data.trueClick);
        data.trueClick = "";
    }
}
