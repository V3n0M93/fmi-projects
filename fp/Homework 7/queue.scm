;;; създава и връща празна опашка
(define (queue-make) 
  (list))

;;; добавя елементите от args в опашката Q
;;; args представлява неограничен брой аргументи ( http://stackoverflow.com/questions/12658406/scheme-how-do-i-handle-an-unspecified-number-of-parameters )
;;; Функцията връща променената опашка
(define (queue-add Q . args) 
  (append Q args))

;;; Премахва първия елемент от опашката
;;; Връща списък с два елемента - 
;;; първият елемент е премахнатия елемент от опашката
;;; втория е променената опашка

(define (queue-pop Q) 
  (list (car Q) (cdr Q)))

;;; Връща броя на елементите в опашката

(define (queue-length Q) 
  (length Q))

;;; Предикат, който връща истина, ако опашката е празна
(define (queue-empty? Q) 
  (null? Q))