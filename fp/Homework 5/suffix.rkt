;Функция range за целта на тестовете
(define (range a b)
  (define (range-iter a b result)
    (cond 
      ((> a b) (reverse result))
      (else (range-iter (+ a 1) b (cons a result)))))
  (range-iter a b '())
  )

(define (suffix? l1 l2)
  (define (suffix?-iter l1 l2)
    (cond
      ((null? l1) #t)
      ((= (car l1)(car l2)) (suffix?-iter (cdr l1) (cdr l2)))
      (else #f)))
  (suffix?-iter (reverse l1) (reverse l2))
  )