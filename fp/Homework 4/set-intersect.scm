(define (is-member-of? el l)
  (cond
    ((null? l) #f)
    ((= (car l) el) #t)
    (else (is-member-of? el (cdr l)))))

(define (remove-duplicates l)
  (define (remove-duplicates-iter l result)
    (cond
      ((null? l) (reverse result))
      ((is-member-of? (car l) result) (remove-duplicates-iter (cdr l) result))
      (else (remove-duplicates-iter (cdr l) (cons (car l) result)))))
  (remove-duplicates-iter l '()))

(define (set-intersect l1 l2) 
  (define (set-intersect-iter l1 l2 result)
    (cond 
      ((null? l1) (selection (remove-duplicates result)))
      ((is-member-of? (car l1) l2) (set-intersect-iter (cdr l1) l2 (cons (car l1) result)))
      (else (set-intersect-iter (cdr l1) l2 result))))
  (set-intersect-iter l1 l2 '()))

; Selection sort from the link
(define (selection L) 
   (cond ( (null? L) '() )
         ( else (cons (smallest L (car L))     ; put the smallest element
                                               ; at the front of the 
                                               ; current list 
                      (selection (remove L (smallest L (car L)))))
                                               ; call selection on the list
                                               ; minus the smallest
                                               ; element
         )
   )
)

(define (remove L A)                ; remove the first occurance of atom A from L
  (cond ( (null? L) '() )           
        ( (= (car L) A) (cdr L))    ; Match found! 
        (else (cons (car L)(remove (cdr L) A)))   ; keep searching
  )
)

(define (smallest L A)             ; looks for the smallest element in the list
                                   ; atom A is the current smallest
  (cond ( (null? L) A)
        ( (< (car L) A) (smallest (cdr L)(car L)))
        (else (smallest (cdr L) A ))
  )
)
