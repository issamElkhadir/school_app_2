export type ToastPosition = 
'top-left'|'top-center'|'top-right'|
'center-left'|'center'|'center-right'|
'bottom-left'|'bottom-center'|'bottom-right';

export type Toast = {
  summary: string;
  detail: string;
  life: ?number;
  severity: 'success'|'info'|'error'|'warn',
  position: ToastPosition
};
