function slug(t = '') {
    if (typeof t === "undefined" || t.length < 1) {
        t = '';
    }
    t = t.toLowerCase();
    t = t.replace(/(á|à|ả|ã|ạ|ă|ắ|ằ|ẳ|ẵ|ặ|â|ấ|ầ|ẩ|ẫ|ậ)+/g, 'a');
    t = t.replace(/(đ)+/g, 'd');
    t = t.replace(/(é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ)+/g, 'e');
    t = t.replace(/(í|ì|ỉ|ĩ|ị)+/g, 'i');
    t = t.replace(/(ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ)+/g, 'o');
    t = t.replace(/(ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ữ|ự|ử)+/g, 'u');
    t = t.replace(/(ý|ỳ|ỷ|ỹ|ỵ)+/g, 'y');
    t = t.replace(/\s+/g, '-');
    t = t.replace(/\-+/g, '-');
    t = t.replace(/[^a-z0-9\-\.]+|^\-+|\-+$/g, '');
    return t;
}
