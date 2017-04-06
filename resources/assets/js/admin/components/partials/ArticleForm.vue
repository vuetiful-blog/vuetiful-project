<style>
.fade-enter-active {
    transition: opacity .5s
}

.fade-enter {
    opacity: 0
}

#blogForm input,
#blogForm #article,
#preview {
    border: 0;
    outline: none;
    font-family: 'Raleway', sans-serif;
    padding: 5px;
}

#blogForm input {
    font-size: 2em;
}

#blogForm #article {
    min-height: 30em;
}

.code-snippet {
    margin: 10px;
}

.code-snippet td {
    color: #999;
    padding-right: 10px;
}

.code-snippet pre {
    border: 0;
}
</style>

<template>
    <div class="ui form" id="blogForm">
        <div class="field">
            <input type="text" placeholder="Title" v-model="title">
        </div>

        <div>
            <div class="ui top attached tabular menu" style="margin-bottom:15px;">
                <a href="#" @click="tab = 'edit'" :class="[{active: tab === 'edit'},'item']">Edit</a>
                <a href="#" @click="getPreview" :class="[{active: tab === 'preview'},'item']">Preview</a>
            </div>

            <div v-show="tab === 'edit'">
                <div class="field">
                    <div contenteditable="true" id="article" ref="article" @input="setArticle" @keyup.221="isCode" @keydown.ctrl.alt.83="addSnippet" @keydown.9.prevent @paste="formatSnippets()" v-once>{{article}}
                    </div>
                </div>
                <button class="ui tiny icon button" @click="addSnippet">
                    <i class="code icon"></i>
                </button>

            </div>
        </div>

        <div v-show="tab === 'preview'" id="preview">
            <div class="ui basic segment" style="min-height:10em;">
                <loader :loading="previewLoading" loading-text="Loading Preview"></loader>
                <transition name="fade">
                    <div v-html="preview" v-show="!previewLoading">
                </transition>
                </div>
            </div>
        </div>
</template>

<script type="text/javascript">
import Loader from '@/components/core/Loader.vue';
export default {
    components: {
        Loader
    },
    methods: {
        setArticle(event) {
            this.article = event.target.innerText;
            this.emitInput();
        },
        emitInput() {
            this.$emit('input', this.title, this.article);
        },
        getPreview() {
            this.previewLoading = true;
            this.tab = 'preview';
            axios.post('/api/articles/preview', {
                article: this.article
            }).then(response => {
                this.preview = response.data;
            }).catch(error => {
                console.log(error);
            }).then(() => {
                this.previewLoading = false;
            });
        },
        formatSnippets() {
            setTimeout(() => {
                let content = this.$refs.article.innerHTML;
                // innerHTML starts with a close div (something contenteditable is doing?), so let's match and remove it,
                // we can replace an additional code div on the replacement. see: https://regex101.com/r/IVIOf3/1 for the regex in action
                content = content.replace(/\[code\s?(lang=\"[a-z]+\")?]<\/div>(.*?)\[\/code\]/ig, (match, p1, p2) => {
                    let codeTag = (p1) ? '[code ' + p1 + ']' : '[code]'
                    return codeTag + '<div style="font-family:courier;">' + p2 + '</div></div>[/code]';
                });
                this.$refs.article.innerHTML = content;
            }, 0);
        },
        addSnippet(includeStartTag = true, code = null) {
            var code = this.htmlEncodeSelection()
            code = (code.length === 0) ? "<br />" : code;
            let tag = (includeStartTag) ? "[code]" : "";
            this.insertHTML(tag + '<div style="font-family:courier;">' + code + '</div>[/code]');
            // Move to the <br /> tag (next line) where the code will be correctly formatted.
            this.moveCaretToNextSiblingsChild();
        },
        htmlEncodeSelection() {
            let selection = window.getSelection().toString();
            return selection.replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;').replace(/\n/g, "<br />");
        },
        isCode(event) {
            // Adds a close tag ([/code]) when opening tag ([code]) is typed.
            let selection = window.getSelection();
            let range = selection.getRangeAt(0);
            let content = selection.anchorNode.data;
            let start = range.startOffset;
            for (var i = start - 1; i >= 0; i--) {
                if (content.charAt(i) === "[") {
                    if (content.substring(i, i + 5) === "[code") {
                        this.addSnippet(false);
                    }
                    break;
                }
            }
        },
        insertHTML(html) {
            // Inserts the given HTML at the caret position
            let sel = window.getSelection();
            let range = sel.getRangeAt(0);
            range.deleteContents();
            // createContextualFragment isn't supported in IE10 and below.
            let frag = range.createContextualFragment(html);
            range.insertNode(frag);
        },
        moveCaretToNextSiblingsChild() {
            let sel = window.getSelection();
            let range = sel.getRangeAt(0);
            range.collapse(true);
            let sibling = range.endContainer.nextElementSibling;
            if (sibling) {
                range.setStart(sibling.childNodes[0], 0);
                sel.removeAllRanges();
                sel.addRange(range);
            }
        },
    },
    watch: {
        title(val) {
            // emit input event when title changes
            this.emitInput();
        }
    },
    data() {
        return {
            article: "",
            title: "",
            tab: 'edit',
            preview: '',
            previewLoading: false
        }
    }
}
</script>
