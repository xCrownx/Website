function openVotePopup(url) {
    var width = 600;
    var height = 400;
    var left = (window.innerWidth - width) / 2;
    var top = (window.innerHeight - height) / 2;

    var options = 'width=' + width + ',height=' + height + ',left=' + left + ',top=' + top + ',status=no,menubar=no,toolbar=no';
    window.open(url, 'VotePopup', options);
}
