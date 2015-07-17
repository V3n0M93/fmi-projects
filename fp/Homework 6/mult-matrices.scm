(define (mult-matrices M1 M2) 
  (define (create-row i j M1 M2 result)
    (cond
      ((= 0 j) result)
      (else (create-row i (- j 1) M1 M2 (cons (reduce + 0 (map * (get-row M1 i) (get-column M2 j ))) result)))))
  (define (mult-matrices-iter M1 M2 i result)
    (cond
      ((= 0 i) result)
      (else (mult-matrices-iter M1 M2 (- i 1) (cons (create-row i (cadr (dimension M2)) M1 M2 '()) result)))))
  (if (can-multiply? M1 M2) (mult-matrices-iter M1 M2 (car (dimension M1)) '()) '()))

;;; функцията взима матрица и връща списък с 2 елемента с размерностите на матрицата
(define (dimension M)
    (cons (length M) (cons (length (car M)) (list) )))
    
;;; предикат, който казва дали две матрици могат да бъдат умножени
;;; MxP * PxN = MxN
(define (first list)
  (car list))

(define (last list)
  (define (last-iter list result)
    (cond
      ( (null? list) result )
      (else (last-iter (cdr list) (car list))))
      )
  (last-iter list (car list)))

(define (can-multiply? M1 M2)
    (= (last (dimension M1)) (first (dimension M2))))

; Reduce функция
(define (reduce oper start_value l)
    (cond
        ((null? l) start_value)
        (else (reduce oper (oper (car l) start_value) (cdr l)))))

; Връща n-тия елемент
(define (nth list n)
  (define (nth-iter list n counter result)
    (cond
      ( (= n counter ) result )
      (else (nth-iter (cdr list) n (+ counter 1) (car list)))))
  
  (nth-iter list n 0 (car list)))

;;; фунция, която връща даден ред (от индекс 1) на матрица
(define (get-row M index)
    (nth M index)) 
      
;;; връща колоната с даден index
(define (get-column M index)
    (map (lambda (row) (nth row index)) M))'

(define (mult-matrices M1 M2) 
  (define (create-row i j M1 M2 result)
    (cond
      ((= 0 j) result)
      (else (create-row i (- j 1) M1 M2 (cons (reduce + 0 (map * (get-row M1 i) (get-column M2 j ))) result)))))
  (define (mult-matrices-iter M1 M2 i result)
    (cond
      ((= 0 i) result)
      (else (mult-matrices-iter M1 M2 (- i 1) (cons (create-row i (cadr (dimension M2)) M1 M2 '()) result)))))
  (if (can-multiply? M1 M2) (mult-matrices-iter M1 M2 (car (dimension M1)) '()) '()))