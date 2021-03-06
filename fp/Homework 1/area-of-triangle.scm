(define (area-of-triangle a b c) 
  (if ( = (* c c) (+ (* a a) (* b b))) 
      (/ (* a b) 2)
      (/ ( sqrt(* (+ a b c) (- (+ a b) c) (- (+ a c) b) (- (+ b c) a))) 4)
  ))