(define (list-compose l)
  (define (list-compose-iter l result)
    (cond 
      ((null? l) result)
      (else (list-compose-iter (cdr l) (lambda (x) (result ((car l) x)))))
      )
    )
  (list-compose-iter (cdr l) (car l))
  )