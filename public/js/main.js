// 削除確認 froms[0] ?
function confirmDelete() {
  if( window.confirm('本当に削除してもよろしいでしょうか?') ) {
    document.forms[0].submit();
  } else {
    return false;
  }
}