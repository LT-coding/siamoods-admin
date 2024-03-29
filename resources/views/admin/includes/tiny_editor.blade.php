<script>
    tinymce.init({
        selector: `#editor`,
        height: 520,
        block_formats: 'Paragraph=p; Header 1=h1; Header 2=h2; Header 3=h3',
        plugins: 'link image table lists',
        contextmenu: 'link image table',
        contextmenu_avoid_overlap: '.mce-spelling-word',
        menubar: 'edit format',
        menu: {
            edit: { title: 'Edit', items: 'undo redo | cut copy paste | selectall | searchreplace' },
            format: { title: 'Format', items: 'strikethrough superscript subscript codeformat | formats blockformats fontformats fontsizes | removeformat' },
        },
        toolbar: [
            { name: "history", items: ["undo","redo"]},
            { name: "styles", items: ["styles"]},
            { name: "formats", items: ["bold","italic","underline"] },
            { name: "alignment",items: ["align","lineheight"]},
            { name: "listing",items: ["bullist","numlist"] },
            { name: "insert",items: ["image","table","link","hr"] },
            { name: "fullscreen",items: ["fullscreen"] },
            { name: "color",items: ["forecolor","backcolor","fontsize"]},
        ],
        file_picker_callback: (cb, value, meta) => {
            const input = document.createElement("input");
            input.setAttribute("type", "file");
            input.setAttribute("accept", "image/*");
            input.addEventListener("change", (e) => {
                const file = e.target.files[0];
                const reader = new FileReader();
                reader.addEventListener("load", () => {
                    const id = "blobid" + new Date().getTime();
                    const blobCache = tinymce.activeEditor.editorUpload.blobCache;
                    const base64 = reader.result.split(",")[1];
                    const blobInfo = blobCache.create(id, file, base64);
                    blobCache.add(blobInfo);
                    cb(blobInfo.blobUri(), { title: file.name });
                });
                reader.readAsDataURL(file);
            });
            input.click();
        },
    });
</script>
