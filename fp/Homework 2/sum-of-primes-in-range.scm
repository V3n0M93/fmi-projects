(define (is-prime? n)
  (define (is-prime-iter? n i)
  (if (= n i) #t (if (= (remainder n i) 0) #f (is-prime-iter? n (+ i 1)))))

  (if (< n 2) #f (is-prime-iter? n 2)))


(define (sum-of-primes-in-range start end)
  (define (sum-of-primes-in-range-iter sum i) 
    (if (> i end) sum (if (is-prime? i) (sum-of-primes-in-range-iter (+ sum i) (+ i 1))  (sum-of-primes-in-range-iter sum (+ i 1)) ))
  )
  (sum-of-primes-in-range-iter 0 start) 
  )