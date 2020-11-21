/*! @source http://purl.eligrey.com/github/FileSaver.js/blob/master/FileSaver.js */
var saveAs = saveAs || function (r) {
    "use strict";
    if ("undefined" == typeof navigator || !/MSIE [1-9]\./.test(navigator.userAgent)) {
        var e = r.document,
            o = function () {
                return r.URL || r.webkitURL || r
            },
            t = e.createElementNS("http://www.w3.org/1999/xhtml", "a"),
            f = "download" in t,
            n = function (r) {
                var e = new MouseEvent("click");
                r.dispatchEvent(e)
            },
            i = /Version\/[\d\.]+.*Safari/.test(navigator.userAgent),
            a = r.webkitRequestFileSystem,
            d = r.requestFileSystem || a || r.mozRequestFileSystem,
            C = function (e) {
                (r.setImmediate || r.setTimeout)(function () {
                    throw e
                }, 0)
            },
            m = "application/octet-stream",
            S = 0,
            h = 4e4,
            g = function (r) {
                var e = function () {
                    "string" == typeof r ? o().revokeObjectURL(r) : r.remove()
                };
                setTimeout(e, h)
            },
            c = function (r, e, o) {
                e = [].concat(e);
                for (var t = e.length; t--;) {
                    var f = r["on" + e[t]];
                    if ("function" == typeof f) try {
                        f.call(r, o || r)
                    } catch (n) {
                        C(n)
                    }
                }
            },
            u = function (r) {
                return /^\s*(?:text\/\S*|application\/xml|\S*\/\S*\+xml)\s*;.*charset\s*=\s*utf-8/i.test(r.type) ? new Blob([String.fromCharCode(65279), r], {
                    type: r.type
                }) : r
            },
            s = function (e, C, h) {
                h || (e = u(e));
                var s, l, v, p = this,
                    w = e.type,
                    y = !1,
                    x = function () {
                        c(p, "writestart progress write writeend".split(" "))
                    },
                    R = function () {
                        if (l && i && "undefined" != typeof FileReader) {
                            var t = new FileReader;
                            return t.onloadend = function () {
                                var r = t.result;
                                l.location.href = "data:attachment/file" + r.slice(r.search(/[,;]/)), p.readyState = p.DONE, x()
                            }, t.readAsDataURL(e), void(p.readyState = p.INIT)
                        }
                        if ((y || !s) && (s = o().createObjectURL(e)), l) l.location.href = s;
                        else {
                            var f = r.open(s, "_blank");
                            void 0 === f && i && (r.location.href = s)
                        }
                        p.readyState = p.DONE, x(), g(s)
                    },
                    O = function (r) {
                        return function () {
                            return p.readyState !== p.DONE ? r.apply(this, arguments) : void 0
                        }
                    },
                    b = {
                        create: !0,
                        exclusive: !1
                    };
                return p.readyState = p.INIT, C || (C = "download"), f ? (s = o().createObjectURL(e), void setTimeout(function () {
                    t.href = s, t.download = C, n(t), x(), g(s), p.readyState = p.DONE
                })) : (r.chrome && w && w !== m && (v = e.slice || e.webkitSlice, e = v.call(e, 0, e.size, m), y = !0), a && "download" !== C && (C += ".download"), (w === m || a) && (l = r), d ? (S += e.size, void d(r.TEMPORARY, S, O(function (r) {
                    r.root.getDirectory("saved", b, O(function (r) {
                        var o = function () {
                            r.getFile(C, b, O(function (r) {
                                r.createWriter(O(function (o) {
                                    o.onwriteend = function (e) {
                                        l.location.href = r.toURL(), p.readyState = p.DONE, c(p, "writeend", e), g(r)
                                    }, o.onerror = function () {
                                        var r = o.error;
                                        r.code !== r.ABORT_ERR && R()
                                    }, "writestart progress write abort".split(" ").forEach(function (r) {
                                        o["on" + r] = p["on" + r]
                                    }), o.write(e), p.abort = function () {
                                        o.abort(), p.readyState = p.DONE
                                    }, p.readyState = p.WRITING
                                }), R)
                            }), R)
                        };
                        r.getFile(C, {
                            create: !1
                        }, O(function (r) {
                            r.remove(), o()
                        }), O(function (r) {
                            r.code === r.NOT_FOUND_ERR ? o() : R()
                        }))
                    }), R)
                }), R)) : void R())
            },
            l = s.prototype,
            v = function (r, e, o) {
                return new s(r, e, o)
            };
        return "undefined" != typeof navigator && navigator.msSaveOrOpenBlob ? function (r, e, o) {
            return o || (r = u(r)), navigator.msSaveOrOpenBlob(r, e || "download")
        } : (l.abort = function () {
            var r = this;
            r.readyState = r.DONE, c(r, "abort")
        }, l.readyState = l.INIT = 0, l.WRITING = 1, l.DONE = 2, l.error = l.onwritestart = l.onprogress = l.onwrite = l.onabort = l.onerror = l.onwriteend = null, v)
    }
}("undefined" != typeof self && self || "undefined" != typeof window && window || this.content);
"undefined" != typeof module && module.exports ? module.exports.saveAs = saveAs : "undefined" != typeof define && null !== define && null !== define.amd && define([], function () {
    return saveAs
});