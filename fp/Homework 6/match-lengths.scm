(define (match-lengths? l1 l2)
  (define (match-lengths-iter l1 l2 difference)
    (cond
      ((null? l1) #t)
      ((= (- (length (car l1)) (length (car l2))) difference) (match-lengths-iter (cdr l1) (cdr l2) difference))
      (else #f)))
  (match-lengths-iter l1 l2 (- (length (car l1)) (length (car l2)))))

(define (range a b)
    (cond
        ( (> a b) (list))
        (else (cons a (range (+ a 1) b)))))