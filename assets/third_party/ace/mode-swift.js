ace.define("ace/mode/doc_comment_highlight_rules", ["require", "exports", "module", "ace/lib/oop", "ace/mode/text_highlight_rules"], function (e, t, n) {
    "use strict";
    var r = e("../lib/oop"), i = e("./text_highlight_rules").TextHighlightRules, s = function () {
        this.$rules = {
            start: [{
                token: "comment.doc.tag",
                regex: "@[\\w\\d_]+"
            }, s.getTagRule(), {defaultToken: "comment.doc", caseInsensitive: !0}]
        }
    };
    r.inherits(s, i), s.getTagRule = function (e) {
        return {token: "comment.doc.tag.storage.type", regex: "\\b(?:TODO|FIXME|XXX|HACK)\\b"}
    }, s.getStartRule = function (e) {
        return {token: "comment.doc", regex: "\\/\\*(?=\\*)", next: e}
    }, s.getEndRule = function (e) {
        return {token: "comment.doc", regex: "\\*\\/", next: e}
    }, t.DocCommentHighlightRules = s
}), ace.define("ace/mode/swift_highlight_rules", ["require", "exports", "module", "ace/lib/oop", "ace/lib/lang", "ace/mode/doc_comment_highlight_rules", "ace/mode/text_highlight_rules"], function (e, t, n) {
    "use strict";
    var r = e("../lib/oop"), i = e("../lib/lang"), s = e("./doc_comment_highlight_rules").DocCommentHighlightRules, o = e("./text_highlight_rules").TextHighlightRules, u = function () {
        function t(e, t) {
            var n = t.nestable || t.interpolation, r = t.interpolation && t.interpolation.nextState || "start", s = {
                regex: e + (t.multiline ? "" : "(?=.)"),
                token: "string.start"
            }, o = [t.escape && {
                regex: t.escape,
                token: "character.escape"
            }, t.interpolation && {
                token: "paren.quasi.start",
                regex: i.escapeRegExp(t.interpolation.lead + t.interpolation.open),
                push: r
            }, t.error && {regex: t.error, token: "error.invalid"}, {
                regex: e + (t.multiline ? "" : "|$"),
                token: "string.end",
                next: n ? "pop" : "start"
            }, {defaultToken: "string"}].filter(Boolean);
            n ? s.push = o : s.next = o;
            if (!t.interpolation)return s;
            var u = t.interpolation.open, a = t.interpolation.close, f = {
                regex: "[" + i.escapeRegExp(u + a) + "]",
                onMatch: function (e, t, n) {
                    this.next = e == u ? this.nextState : "";
                    if (e == u && n.length)return n.unshift("start", t), "paren";
                    if (e == a && n.length) {
                        n.shift(), this.next = n.shift();
                        if (this.next.indexOf("string") != -1)return "paren.quasi.end"
                    }
                    return e == u ? "paren.lparen" : "paren.rparen"
                },
                nextState: r
            };
            return [f, s]
        }

        function n() {
            return [{
                token: "comment",
                regex: "\\/\\/(?=.)",
                next: [s.getTagRule(), {token: "comment", regex: "$|^", next: "start"}, {
                    defaultToken: "comment",
                    caseInsensitive: !0
                }]
            }, s.getStartRule("doc-start"), {
                token: "comment.start",
                regex: /\/\*/,
                stateName: "nested_comment",
                push: [s.getTagRule(), {
                    token: "comment.start",
                    regex: /\/\*/,
                    push: "nested_comment"
                }, {token: "comment.end", regex: "\\*\\/", next: "pop"}, {defaultToken: "comment", caseInsensitive: !0}]
            }]
        }

        var e = this.createKeywordMapper({
            "variable.language": "",
            keyword: "__COLUMN__|__FILE__|__FUNCTION__|__LINE__|as|associativity|break|case|class|continue|default|deinit|didSet|do|dynamicType|else|enum|extension|fallthrough|for|func|get|if|import|in|infix|init|inout|is|left|let|let|mutating|new|none|nonmutating|operator|override|postfix|precedence|prefix|protocol|return|right|safe|Self|self|set|struct|subscript|switch|Type|typealias|unowned|unsafe|var|weak|where|while|willSet|convenience|dynamic|final|infix|lazy|mutating|nonmutating|optional|override|postfix|prefix|required|static|guard|defer",
            "storage.type": "bool|double|Double|extension|float|Float|int|Int|private|public|string|String",
            "constant.language": "false|Infinity|NaN|nil|no|null|null|off|on|super|this|true|undefined|yes",
            "support.function": ""
        }, "identifier");
        this.$rules = {
            start: [t('"', {
                escape: /\\(?:[0\\tnr"']|u{[a-fA-F1-9]{0,8}})/,
                interpolation: {lead: "\\", open: "(", close: ")"},
                error: /\\./,
                multiline: !1
            }), n({type: "c", nestable: !0}), {
                regex: /@[a-zA-Z_$][a-zA-Z_$\d\u0080-\ufffe]*/,
                token: "variable.parameter"
            }, {regex: /[a-zA-Z_$][a-zA-Z_$\d\u0080-\ufffe]*/, token: e}, {
                token: "constant.numeric",
                regex: /[+-]?(?:0(?:b[01]+|o[0-7]+|x[\da-fA-F])|\d+(?:(?:\.\d*)?(?:[PpEe][+-]?\d+)?)\b)/
            }, {
                token: "keyword.operator",
                regex: /--|\+\+|===|==|=|!=|!==|<=|>=|<<=|>>=|>>>=|<>|<|>|!|&&|\|\||\?\:|[!$%&*+\-~\/^]=?/,
                next: "start"
            }, {token: "punctuation.operator", regex: /[?:,;.]/, next: "start"}, {
                token: "paren.lparen",
                regex: /[\[({]/,
                next: "start"
            }, {token: "paren.rparen", regex: /[\])}]/}]
        }, this.embedRules(s, "doc-", [s.getEndRule("start")]), this.normalizeRules()
    };
    r.inherits(u, o), t.HighlightRules = u
}), ace.define("ace/mode/behaviour/cstyle", ["require", "exports", "module", "ace/lib/oop", "ace/mode/behaviour", "ace/token_iterator", "ace/lib/lang"], function (e, t, n) {
    "use strict";
    var r = e("../../lib/oop"), i = e("../behaviour").Behaviour, s = e("../../token_iterator").TokenIterator, o = e("../../lib/lang"), u = ["text", "paren.rparen", "punctuation.operator"], a = ["text", "paren.rparen", "punctuation.operator", "comment"], f, l = {}, c = function (e) {
        var t = -1;
        e.multiSelect && (t = e.selection.index, l.rangeCount != e.multiSelect.rangeCount && (l = {rangeCount: e.multiSelect.rangeCount}));
        if (l[t])return f = l[t];
        f = l[t] = {
            autoInsertedBrackets: 0,
            autoInsertedRow: -1,
            autoInsertedLineEnd: "",
            maybeInsertedBrackets: 0,
            maybeInsertedRow: -1,
            maybeInsertedLineStart: "",
            maybeInsertedLineEnd: ""
        }
    }, h = function (e, t, n, r) {
        var i = e.end.row - e.start.row;
        return {text: n + t + r, selection: [0, e.start.column + 1, i, e.end.column + (i ? 0 : 1)]}
    }, p = function () {
        this.add("braces", "insertion", function (e, t, n, r, i) {
            var s = n.getCursorPosition(), u = r.doc.getLine(s.row);
            if (i == "{") {
                c(n);
                var a = n.getSelectionRange(), l = r.doc.getTextRange(a);
                if (l !== "" && l !== "{" && n.getWrapBehavioursEnabled())return h(a, l, "{", "}");
                if (p.isSaneInsertion(n, r))return /[\]\}\)]/.test(u[s.column]) || n.inMultiSelectMode ? (p.recordAutoInsert(n, r, "}"), {
                    text: "{}",
                    selection: [1, 1]
                }) : (p.recordMaybeInsert(n, r, "{"), {text: "{", selection: [1, 1]})
            } else if (i == "}") {
                c(n);
                var d = u.substring(s.column, s.column + 1);
                if (d == "}") {
                    var v = r.$findOpeningBracket("}", {column: s.column + 1, row: s.row});
                    if (v !== null && p.isAutoInsertedClosing(s, u, i))return p.popAutoInsertedClosing(), {
                        text: "",
                        selection: [1, 1]
                    }
                }
            } else {
                if (i == "\n" || i == "\r\n") {
                    c(n);
                    var m = "";
                    p.isMaybeInsertedClosing(s, u) && (m = o.stringRepeat("}", f.maybeInsertedBrackets), p.clearMaybeInsertedClosing());
                    var d = u.substring(s.column, s.column + 1);
                    if (d === "}") {
                        var g = r.findMatchingBracket({row: s.row, column: s.column + 1}, "}");
                        if (!g)return null;
                        var y = this.$getIndent(r.getLine(g.row))
                    } else {
                        if (!m) {
                            p.clearMaybeInsertedClosing();
                            return
                        }
                        var y = this.$getIndent(u)
                    }
                    var b = y + r.getTabString();
                    return {text: "\n" + b + "\n" + y + m, selection: [1, b.length, 1, b.length]}
                }
                p.clearMaybeInsertedClosing()
            }
        }), this.add("braces", "deletion", function (e, t, n, r, i) {
            var s = r.doc.getTextRange(i);
            if (!i.isMultiLine() && s == "{") {
                c(n);
                var o = r.doc.getLine(i.start.row), u = o.substring(i.end.column, i.end.column + 1);
                if (u == "}")return i.end.column++, i;
                f.maybeInsertedBrackets--
            }
        }), this.add("parens", "insertion", function (e, t, n, r, i) {
            if (i == "(") {
                c(n);
                var s = n.getSelectionRange(), o = r.doc.getTextRange(s);
                if (o !== "" && n.getWrapBehavioursEnabled())return h(s, o, "(", ")");
                if (p.isSaneInsertion(n, r))return p.recordAutoInsert(n, r, ")"), {text: "()", selection: [1, 1]}
            } else if (i == ")") {
                c(n);
                var u = n.getCursorPosition(), a = r.doc.getLine(u.row), f = a.substring(u.column, u.column + 1);
                if (f == ")") {
                    var l = r.$findOpeningBracket(")", {column: u.column + 1, row: u.row});
                    if (l !== null && p.isAutoInsertedClosing(u, a, i))return p.popAutoInsertedClosing(), {
                        text: "",
                        selection: [1, 1]
                    }
                }
            }
        }), this.add("parens", "deletion", function (e, t, n, r, i) {
            var s = r.doc.getTextRange(i);
            if (!i.isMultiLine() && s == "(") {
                c(n);
                var o = r.doc.getLine(i.start.row), u = o.substring(i.start.column + 1, i.start.column + 2);
                if (u == ")")return i.end.column++, i
            }
        }), this.add("brackets", "insertion", function (e, t, n, r, i) {
            if (i == "[") {
                c(n);
                var s = n.getSelectionRange(), o = r.doc.getTextRange(s);
                if (o !== "" && n.getWrapBehavioursEnabled())return h(s, o, "[", "]");
                if (p.isSaneInsertion(n, r))return p.recordAutoInsert(n, r, "]"), {text: "[]", selection: [1, 1]}
            } else if (i == "]") {
                c(n);
                var u = n.getCursorPosition(), a = r.doc.getLine(u.row), f = a.substring(u.column, u.column + 1);
                if (f == "]") {
                    var l = r.$findOpeningBracket("]", {column: u.column + 1, row: u.row});
                    if (l !== null && p.isAutoInsertedClosing(u, a, i))return p.popAutoInsertedClosing(), {
                        text: "",
                        selection: [1, 1]
                    }
                }
            }
        }), this.add("brackets", "deletion", function (e, t, n, r, i) {
            var s = r.doc.getTextRange(i);
            if (!i.isMultiLine() && s == "[") {
                c(n);
                var o = r.doc.getLine(i.start.row), u = o.substring(i.start.column + 1, i.start.column + 2);
                if (u == "]")return i.end.column++, i
            }
        }), this.add("string_dquotes", "insertion", function (e, t, n, r, i) {
            if (i == '"' || i == "'") {
                c(n);
                var s = i, o = n.getSelectionRange(), u = r.doc.getTextRange(o);
                if (u !== "" && u !== "'" && u != '"' && n.getWrapBehavioursEnabled())return h(o, u, s, s);
                if (!u) {
                    var a = n.getCursorPosition(), f = r.doc.getLine(a.row), l = f.substring(a.column - 1, a.column), p = f.substring(a.column, a.column + 1), d = r.getTokenAt(a.row, a.column), v = r.getTokenAt(a.row, a.column + 1);
                    if (l == "\\" && d && /escape/.test(d.type))return null;
                    var m = d && /string|escape/.test(d.type), g = !v || /string|escape/.test(v.type), y;
                    if (p == s)y = m !== g; else {
                        if (m && !g)return null;
                        if (m && g)return null;
                        var b = r.$mode.tokenRe;
                        b.lastIndex = 0;
                        var w = b.test(l);
                        b.lastIndex = 0;
                        var E = b.test(l);
                        if (w || E)return null;
                        if (p && !/[\s;,.})\]\\]/.test(p))return null;
                        y = !0
                    }
                    return {text: y ? s + s : "", selection: [1, 1]}
                }
            }
        }), this.add("string_dquotes", "deletion", function (e, t, n, r, i) {
            var s = r.doc.getTextRange(i);
            if (!i.isMultiLine() && (s == '"' || s == "'")) {
                c(n);
                var o = r.doc.getLine(i.start.row), u = o.substring(i.start.column + 1, i.start.column + 2);
                if (u == s)return i.end.column++, i
            }
        })
    };
    p.isSaneInsertion = function (e, t) {
        var n = e.getCursorPosition(), r = new s(t, n.row, n.column);
        if (!this.$matchTokenType(r.getCurrentToken() || "text", u)) {
            var i = new s(t, n.row, n.column + 1);
            if (!this.$matchTokenType(i.getCurrentToken() || "text", u))return !1
        }
        return r.stepForward(), r.getCurrentTokenRow() !== n.row || this.$matchTokenType(r.getCurrentToken() || "text", a)
    }, p.$matchTokenType = function (e, t) {
        return t.indexOf(e.type || e) > -1
    }, p.recordAutoInsert = function (e, t, n) {
        var r = e.getCursorPosition(), i = t.doc.getLine(r.row);
        this.isAutoInsertedClosing(r, i, f.autoInsertedLineEnd[0]) || (f.autoInsertedBrackets = 0), f.autoInsertedRow = r.row, f.autoInsertedLineEnd = n + i.substr(r.column), f.autoInsertedBrackets++
    }, p.recordMaybeInsert = function (e, t, n) {
        var r = e.getCursorPosition(), i = t.doc.getLine(r.row);
        this.isMaybeInsertedClosing(r, i) || (f.maybeInsertedBrackets = 0), f.maybeInsertedRow = r.row, f.maybeInsertedLineStart = i.substr(0, r.column) + n, f.maybeInsertedLineEnd = i.substr(r.column), f.maybeInsertedBrackets++
    }, p.isAutoInsertedClosing = function (e, t, n) {
        return f.autoInsertedBrackets > 0 && e.row === f.autoInsertedRow && n === f.autoInsertedLineEnd[0] && t.substr(e.column) === f.autoInsertedLineEnd
    }, p.isMaybeInsertedClosing = function (e, t) {
        return f.maybeInsertedBrackets > 0 && e.row === f.maybeInsertedRow && t.substr(e.column) === f.maybeInsertedLineEnd && t.substr(0, e.column) == f.maybeInsertedLineStart
    }, p.popAutoInsertedClosing = function () {
        f.autoInsertedLineEnd = f.autoInsertedLineEnd.substr(1), f.autoInsertedBrackets--
    }, p.clearMaybeInsertedClosing = function () {
        f && (f.maybeInsertedBrackets = 0, f.maybeInsertedRow = -1)
    }, r.inherits(p, i), t.CstyleBehaviour = p
}), ace.define("ace/mode/folding/cstyle", ["require", "exports", "module", "ace/lib/oop", "ace/range", "ace/mode/folding/fold_mode"], function (e, t, n) {
    "use strict";
    var r = e("../../lib/oop"), i = e("../../range").Range, s = e("./fold_mode").FoldMode, o = t.FoldMode = function (e) {
        e && (this.foldingStartMarker = new RegExp(this.foldingStartMarker.source.replace(/\|[^|]*?$/, "|" + e.start)), this.foldingStopMarker = new RegExp(this.foldingStopMarker.source.replace(/\|[^|]*?$/, "|" + e.end)))
    };
    r.inherits(o, s), function () {
        this.foldingStartMarker = /(\{|\[)[^\}\]]*$|^\s*(\/\*)/, this.foldingStopMarker = /^[^\[\{]*(\}|\])|^[\s\*]*(\*\/)/, this.singleLineBlockCommentRe = /^\s*(\/\*).*\*\/\s*$/, this.tripleStarBlockCommentRe = /^\s*(\/\*\*\*).*\*\/\s*$/, this.startRegionRe = /^\s*(\/\*|\/\/)#?region\b/, this._getFoldWidgetBase = this.getFoldWidget, this.getFoldWidget = function (e, t, n) {
            var r = e.getLine(n);
            if (this.singleLineBlockCommentRe.test(r) && !this.startRegionRe.test(r) && !this.tripleStarBlockCommentRe.test(r))return "";
            var i = this._getFoldWidgetBase(e, t, n);
            return !i && this.startRegionRe.test(r) ? "start" : i
        }, this.getFoldWidgetRange = function (e, t, n, r) {
            var i = e.getLine(n);
            if (this.startRegionRe.test(i))return this.getCommentRegionBlock(e, i, n);
            var s = i.match(this.foldingStartMarker);
            if (s) {
                var o = s.index;
                if (s[1])return this.openingBracketBlock(e, s[1], n, o);
                var u = e.getCommentFoldRange(n, o + s[0].length, 1);
                return u && !u.isMultiLine() && (r ? u = this.getSectionRange(e, n) : t != "all" && (u = null)), u
            }
            if (t === "markbegin")return;
            var s = i.match(this.foldingStopMarker);
            if (s) {
                var o = s.index + s[0].length;
                return s[1] ? this.closingBracketBlock(e, s[1], n, o) : e.getCommentFoldRange(n, o, -1)
            }
        }, this.getSectionRange = function (e, t) {
            var n = e.getLine(t), r = n.search(/\S/), s = t, o = n.length;
            t += 1;
            var u = t, a = e.getLength();
            while (++t < a) {
                n = e.getLine(t);
                var f = n.search(/\S/);
                if (f === -1)continue;
                if (r > f)break;
                var l = this.getFoldWidgetRange(e, "all", t);
                if (l) {
                    if (l.start.row <= s)break;
                    if (l.isMultiLine())t = l.end.row; else if (r == f)break
                }
                u = t
            }
            return new i(s, o, u, e.getLine(u).length)
        }, this.getCommentRegionBlock = function (e, t, n) {
            var r = t.search(/\s*$/), s = e.getLength(), o = n, u = /^\s*(?:\/\*|\/\/|--)#?(end)?region\b/, a = 1;
            while (++n < s) {
                t = e.getLine(n);
                var f = u.exec(t);
                if (!f)continue;
                f[1] ? a-- : a++;
                if (!a)break
            }
            var l = n;
            if (l > o)return new i(o, r, l, t.length)
        }
    }.call(o.prototype)
}), ace.define("ace/mode/swift", ["require", "exports", "module", "ace/lib/oop", "ace/mode/text", "ace/mode/swift_highlight_rules", "ace/mode/behaviour/cstyle", "ace/mode/folding/cstyle"], function (e, t, n) {
    "use strict";
    var r = e("../lib/oop"), i = e("./text").Mode, s = e("./swift_highlight_rules").HighlightRules, o = e("./behaviour/cstyle").CstyleBehaviour, u = e("./folding/cstyle").FoldMode, a = function () {
        this.HighlightRules = s, this.foldingRules = new u, this.$behaviour = new o
    };
    r.inherits(a, i), function () {
        this.lineCommentStart = "//", this.blockComment = {
            start: "/*",
            end: "*/",
            nestable: !0
        }, this.$id = "ace/mode/swift"
    }.call(a.prototype), t.Mode = a
})