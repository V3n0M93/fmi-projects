(define (digits-sum n) 
  (if (< n 10) n (+ (remainder n 10) (digits-sum (quotient n 10))))
  )