(define (is-int-palindrom? n) 
  (define (is-int-palindrom-iter? reverse i) 
    (if (= (quotient n (expt 10 i)) 0) reverse (is-int-palindrom-iter? (+ (* reverse 10) (quotient (remainder n (expt 10(+ i 1))) (expt 10 i)) ) (+ i 1)))
  )
  (if (= (is-int-palindrom-iter? 0 0) n) #t #f)
  )







