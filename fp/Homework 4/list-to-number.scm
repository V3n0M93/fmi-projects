(define (list-to-number l)
  (define (list-to-number-iter l result)
    (cond 
      ((null? l) result)
      (else (list-to-number-iter (cdr l) (+ (* result 10) (car l))))
      )
    )
  (list-to-number-iter l 0)
  )