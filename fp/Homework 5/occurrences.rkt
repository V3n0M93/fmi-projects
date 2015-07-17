(define (occurrences l1 l2)
  ;Помощна функция връщаща броя на срещанията на елемент в списък
  (define (occurrences-el el l)
    (define (occurrences-el-iter el l result)
    (cond
      ((null? l) result)
      ((= (car l) el) (occurrences-el-iter el (cdr l) (+ result 1)))
      (else (occurrences-el-iter el (cdr l) result))
      ))
    (occurrences-el-iter el l 0))
  
  (define (occurrences-iter l1 l2 result)
    (cond
      ((null? l1) (reverse result))
      (else (occurrences-iter (cdr l1) l2 (cons (occurrences-el (car l1) l2) result)))))
  (occurrences-iter l1 l2 '()))