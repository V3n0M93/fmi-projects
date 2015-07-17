(define (atom? x) (not (or (pair? x) (null? x))))

(define (add-elements L1 L2)
  (cond
    ((null? L2) L1)
    (else (add-elements (cons (car L2) L1) (cdr L2)))))

(define (is-ironed L)
  (cond
    ((null? L) #t)
    ((atom? (car L)) (is-ironed (cdr L)))
    (else #f)))

(define (steam-ironing L)
  (define (steam-ironing-iter L result)
    (cond
      ((null? L) (reverse result))
      ((atom? (car L)) (steam-ironing-iter (cdr L) (cons (car L) result)))
      (else (steam-ironing-iter (cdr L) (add-elements result (car L))))))
  (cond
    ((is-ironed L) L)
    (else (steam-ironing (steam-ironing-iter L '())))))