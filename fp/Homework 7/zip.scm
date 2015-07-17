(define (zip l1 l2)
  (define (zip-iter l1 l2 result)
  (cond 
    ((null? l1) result)
    (else (zip-iter (cdr l1) (cdr l2) (append result (list (list (car l1) (car l2)))) ))))
  (zip-iter l1 l2 '()))