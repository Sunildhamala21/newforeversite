import { ClassicEditor, Essentials, Bold, Italic, Paragraph, Heading, Link, List, MediaEmbed, SimpleUploadAdapter, ImageBlock, ImageTextAlternative, ImageCaption, ImageInsert, ImageToolbar, WordCount, SourceEditing, Table, TableToolbar, TableCaption, RemoveFormat, BlockQuote } from 'ckeditor5';
import 'ckeditor5/ckeditor5.css';

const editors = document.querySelectorAll('.editor');

if (editors) {
  editors.forEach(editor => {
    ClassicEditor
      .create(editor, {
        licenseKey: 'GPL',
        plugins: [Essentials, Bold, Italic, Paragraph, Heading, Link, BlockQuote, List, MediaEmbed, Image, SimpleUploadAdapter, ImageBlock, ImageTextAlternative, ImageCaption, ImageInsert, ImageToolbar, WordCount, SourceEditing, Table, TableToolbar, TableCaption, RemoveFormat],
        toolbar: [
          'undo', 'redo', '|', 'heading', 'bold', 'italic', 'removeFormat', '|', 'link', 'bulletedList', 'numberedList', 'blockQuote', 'insertImage', 'insertTable', 'mediaEmbed', '|', 'sourceEditing',
        ],
        image: {
          toolbar: ['toggleImageCaption', 'imageTextAlternative']
        },
        table: {
          contentToolbar: ['tableColumn', 'tableRow', 'mergeTableCells', 'toggleTableCaption'],
          defaultHeadings: {
            rows: 1
          }
        },
        simpleUpload: {
          uploadUrl: 'admin/description-images/save',
          withCredentials: true,
          headers: {
            'X-CSRF-TOKEN': document.head.querySelector('meta[name="csrf-token"]').content
          }
        },
        mediaEmbed: {
          previewsInData: true
        }
      }).then(editor => {
        if (document.querySelector('#word-count')) {
          const wordCountPlugin = editor.plugins.get('WordCount');
          document.querySelector('#word-count').appendChild(wordCountPlugin.wordCountContainer);
        }
      });
  })
}
