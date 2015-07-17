(define (lower-than-harmonic l) 
  (define (harmonic l)
    (define (harmonic-iter l result n)
      (cond
        ((null? l) (/ n result))
        (else (harmonic-iter (cdr l) (+ result (/ 1 (car l))) n))))
    (harmonic-iter l 0 (length l)))
  (filter l (lambda (x) (< x (harmonic l)))))

(define (filter l pred?)
  (define (filter-iter l pred? result)
    (cond
      ( (null? l) result)
      ( (pred? (car l)) (filter-iter (cdr l) pred? (cons (car l) result)))
      (else (filter-iter (cdr l) pred? result))))

  (reverse (filter-iter l pred? '())))