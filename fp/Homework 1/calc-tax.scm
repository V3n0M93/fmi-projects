(define (calc-tax amount) 
  (cond 
    ((<= amount 8000) 0)
    ((<= amount 48000) (* 0.2 amount))
    (else (+ 8000 (* 0.4 (- amount 48000)) )))
  )