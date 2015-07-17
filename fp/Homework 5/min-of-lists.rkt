;Помощна функция - връща най-малкия елемент от списък
(define (min-el l)
  (define (min-el-iter l result)
    (cond
      ((null? l) result)
      ((< (car l) result) (min-el-iter (cdr l) (car l)))
      (else (min-el-iter (cdr l) result))))
  (min-el-iter (cdr l) (car l)))

(define (min-of-lists l)
  (define (min-of-lists-iter l result)
    (cond
      ((null? l) (reverse result))
      (else (min-of-lists-iter (cdr l) (cons (min-el (car l)) result)))))
  (min-of-lists-iter l '()))